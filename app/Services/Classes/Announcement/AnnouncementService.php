<?php


namespace App\Services\Classes\Announcement;


use App\Exceptions\CustomException;
use App\Http\Requests\AnnouncementRequest;
use App\Repository\Structure\AnnouncementRepository;
use JetBrains\PhpStorm\ArrayShape;

class AnnouncementService implements AnnouncementServiceInterface
{
    protected AnnouncementRepository $repository;

    public function __construct(AnnouncementRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    #[ArrayShape(['announcements' => "\Illuminate\Database\Eloquent\Collection"])] public function index(): array
    {
        return [
            'announcements' => $this->repository->findAll()
        ];
    }

    /**
     * @param $id
     * @return array
     */
    #[ArrayShape(['announcement' => "mixed"])] public function show($id): array
    {
        return [
          'announcement' => $this->repository->findOneById($id)
        ];
    }

    /**
     * @param AnnouncementRequest $request
     * @throws CustomException
     */
    public function create(AnnouncementRequest $request)
    {
        $data = filterRequest($request->validated());
        $this->repository->createOne($data);
    }

    /**
     * @param AnnouncementRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(AnnouncementRequest $request, $id)
    {
        $data = filterRequest($request->validated());
        $this->repository->updateById($id, $data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->repository->forceDeleteById($id);
    }
}
