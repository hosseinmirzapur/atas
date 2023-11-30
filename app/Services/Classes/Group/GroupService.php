<?php


namespace App\Services\Classes\Group;


use App\Http\Requests\GroupRequest;
use App\Http\Requests\GroupUsersRequest;
use App\Http\Resources\GroupResource;
use JetBrains\PhpStorm\ArrayShape;

class GroupService implements GroupServiceInterface
{
    #[ArrayShape([
        'groups' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"
    ])]
    public function userGroups(): array
    {
        $user = currentUser();
        $groups = $user->groups()->get();
        return [
            'groups' => GroupResource::collection($groups)
        ];
    }

    public function create(GroupRequest $request)
    {
        // TODO: Implement create() method.
    }

    public function update(GroupRequest $request, $id)
    {
        // TODO: Implement update() method.
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function addUsers(GroupUsersRequest $request)
    {
        // TODO: Implement addUsers() method.
    }

    public function removeUsers(GroupUsersRequest $request)
    {
        // TODO: Implement removeUsers() method.
    }
}
