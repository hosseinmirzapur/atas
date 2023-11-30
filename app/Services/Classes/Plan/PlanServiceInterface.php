<?php

namespace App\Services\Classes\Plan;

use App\Exceptions\CustomException;
use App\Http\Requests\GrantOptionsToPlanRequest;
use App\Http\Requests\PlanRequest;

interface PlanServiceInterface
{
    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param PlanRequest $request
     * @throws CustomException
     */
    public function create(PlanRequest $request);

    /**
     * @param $id
     * @return array
     */
    public function show($id): array;

    /**
     * @param PlanRequest $request
     * @param $id
     */
    public function update(PlanRequest $request, $id);

    /**
     * @param $id
     */
    public function delete($id);

    /**
     * @param GrantOptionsToPlanRequest $request
     */
    public function grantOptionsToPlan(GrantOptionsToPlanRequest $request);
}
