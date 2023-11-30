<?php

namespace App\Services\Classes\Announcement;

use App\Http\Requests\AnnouncementRequest;

interface AnnouncementServiceInterface
{
    /**
     * @return array
     */
    public function index(): array;

    /**
     * @param $id
     * @return array
     */
    public function show($id): array;

    /**
     * @param AnnouncementRequest $request
     */
    public function create(AnnouncementRequest $request);

    /**
     * @param AnnouncementRequest $request
     * @param $id
     */
    public function update(AnnouncementRequest $request, $id);

    /**
     * @param $id
     */
    public function delete($id);
}
