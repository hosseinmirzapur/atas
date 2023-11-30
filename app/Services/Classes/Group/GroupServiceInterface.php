<?php


namespace App\Services\Classes\Group;


use App\Http\Requests\GroupRequest;
use App\Http\Requests\GroupUsersRequest;

interface GroupServiceInterface
{
    public function userGroups(): array;

    public function create(GroupRequest $request);

    public function update(GroupRequest $request, $id);

    public function show($id);

    public function addUsers(GroupUsersRequest $request);

    public function removeUsers(GroupUsersRequest $request);

}
