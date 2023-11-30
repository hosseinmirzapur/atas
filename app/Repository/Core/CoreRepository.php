<?php


namespace App\Repository\Core;


use App\Exceptions\CustomException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use ReflectionException;

class CoreRepository
{
    protected Model $model;

    /**
     * @param string $model
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct(string $model)
    {
        $reflection = new ReflectionClass($model);
        $modelInstance = $reflection->newInstance();
        if ($modelInstance instanceof Model) {
            $this->model = $modelInstance;
        } else {
            throw new Exception('Incompatible class type', 500);
        }
    }

    /**
     * @param array $relations
     * @param array $columns
     * @return Collection
     */
    public function findAll(array $relations = [], array $columns = ['*']): Collection
    {
        return $this->model::with($relations)->get($columns);
    }

    /**
     * @param mixed $id
     * @param array $relations
     * @param bool $throw
     * @return Model|Collection|Builder|array|null
     */
    public function findOneById(mixed $id, array $relations = [], bool $throw = true): Model|Collection|Builder|array|null
    {
        return $throw ? $this->model::with($relations)->findOrFail($id) : $this->model::with($relations)->find($id);
    }

    /**
     * @param string $attr
     * @param mixed $value
     * @param array $relations
     * @param bool $throw
     * @return Model|Builder
     */
    public function findOneByAttr(string $attr, mixed $value, array $relations = [], bool $throw = true): Model|Builder
    {
        return $throw ? $this->model::with($relations)
            ->where($attr, $value)
            ->firstOrFail() : $this->model::with($relations)
            ->where($attr, $value)
            ->first();
    }

    /**
     * @param string $attr
     * @param mixed $value
     * @param array $relations
     * @param array|string[] $columns
     * @return Collection|array
     */
    public function findManyByAttr(string $attr, mixed $value, array $relations = [], array $columns = ['*']): Collection|array
    {
        return $this->model::with($relations)->where($attr, $value)->get($columns);
    }

    /**
     * @param string $attr
     * @param mixed $value
     * @param array $relations
     * @param array|string[] $columns
     * @return Collection|array
     */
    public function search(string $attr, mixed $value, array $relations = [], array $columns = ['*']): Collection|array
    {
        return $this->model::with($relations)->where($attr, 'LIKE', '%' . $value . '%')->get($columns);
    }

    /**
     * @param array $data
     * @return Model|Builder|null
     * @throws CustomException
     */
    public function createOne(array $data): Model|Builder|null
    {
        return $this->model::query()->updateOrCreate(filterRequest($data), filterRequest($data))->fresh();
    }

    /**
     * @param array $arrayOfArrays
     * @return Collection
     * @throws CustomException
     */
    public function createMany(array $arrayOfArrays): Collection
    {
        $allData = new Collection();
        foreach ($arrayOfArrays as $singleArrayData) {
            $allData->add($this->createOne($singleArrayData));
        }
        return $allData;
    }

    /**
     * @param string $searchAttr
     * @param mixed $searchValue
     * @param array $data
     * @param bool $throw
     * @return Model|Builder|null
     * @throws CustomException
     */
    public function updateOneByAttr(string $searchAttr, mixed $searchValue, array $data, bool $throw = true): Model|Builder|null
    {
        $object = $this->findOneByAttr($searchAttr, $searchValue, [], $throw);
        $object->update(filterRequest($data));
        return $object->fresh();
    }

    /**
     * @param mixed $id
     * @param array $data
     * @param bool $throw
     * @return Model|Builder|null
     * @throws CustomException
     */
    public function updateById(mixed $id, array $data, bool $throw = true): Model|Builder|null
    {
        return $this->updateOneByAttr('id', $id, $data, $throw);
    }

    /**
     * @param string $searchAttr
     * @param mixed $searchValue
     */
    public function deleteByAttr(string $searchAttr, mixed $searchValue)
    {
        $this->findOneByAttr($searchAttr, $searchValue);
        $this->model::query()->where($searchAttr, $searchValue)->delete();
    }

    /**
     * @param mixed $id
     */
    public function deleteById(mixed $id)
    {
        $this->findOneById($id);
        $this->deleteByAttr('id', $id);
    }

    /**
     * @param string $searchAttr
     * @param mixed $searchValue
     */
    public function forceDeleteByAttribute(string $searchAttr, mixed $searchValue)
    {
        $this->findOneByAttr($searchAttr, $searchValue);
        $this->model::query()->where($searchAttr, $searchValue)->forceDelete();
    }

    /**
     * @param mixed $id
     */
    public function forceDeleteById(mixed $id)
    {
        $this->findOneById($id);
        $this->forceDeleteByAttribute('id', $id);
    }
}
