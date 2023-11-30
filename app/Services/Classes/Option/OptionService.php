<?php


namespace App\Services\Classes\Option;


use App\Exceptions\CustomException;
use App\Http\Requests\OptionRequest;
use App\Repository\Structure\OptionRepository;
use JetBrains\PhpStorm\ArrayShape;

class OptionService implements OptionServiceInterface
{
    protected OptionRepository $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * @return array
     */
    #[ArrayShape(['options' => "\Illuminate\Database\Eloquent\Collection"])] public function all(): array
    {
        return [
            'options' => $this->optionRepository->findAll()
        ];
    }

    /**
     * @param OptionRequest $request
     * @throws CustomException
     */
    public function create(OptionRequest $request)
    {
        $this->optionRepository->createOne($request->validated());
    }

    /**
     * @param OptionRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(OptionRequest $request, $id)
    {
        $this->optionRepository->updateById($id, filterRequest($request->validated()));
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->optionRepository->forceDeleteById($id);
    }
}
