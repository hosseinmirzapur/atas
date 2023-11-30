<?php


namespace App\Services\Classes\Follow;


use App\Exceptions\CustomException;
use App\Http\Requests\FollowRequest;
use App\Http\Resources\FollowerResource;
use App\Http\Resources\FollowingResource;
use App\Models\Follow;
use App\Repository\Structure\FollowRepository;
use App\Repository\Structure\UserRepository;
use JetBrains\PhpStorm\ArrayShape;

class FollowService implements FollowServiceInterface
{
    protected FollowRepository $followRepository;
    protected UserRepository $userRepository;

    public function __construct(FollowRepository $followRepository, UserRepository $userRepository)
    {
        $this->followRepository = $followRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param FollowRequest $request
     * @throws CustomException
     */
    public function followUser(FollowRequest $request)
    {
        $following_user_id = $request->user_id;
        $this->userRepository->findOneById($following_user_id);
        $user = currentUser();
        if ($user->id == $following_user_id) {
            throw new CustomException(trans('messages.CANNOT_FOLLOW_SELF'));
        }
        $item = Follow::query()->where('user_id', $user->id)->where('following_user_id', $following_user_id)->first();
        if (!exists($item)) {
            $this->followRepository->createOne([
                'user_id' => $user->id,
                'following_user_id' => $following_user_id
            ]);
        }
    }

    public function unfollowUser(FollowRequest $request)
    {
        $following_user_id = $request->user_id;
        $this->userRepository->findOneById($following_user_id);
        $item = Follow::query()->where('user_id', currentUser()->id)->where('following_user_id', $following_user_id)->firstOrFail();
        $item->delete();
    }

    /**
     * @param $user_id
     * @return array
     */
    #[ArrayShape(['followers' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function followers($user_id): array
    {
        $user = $this->userRepository->findOneById($user_id);
        $followers = $user->followers;
        return [
            'followers' => FollowerResource::collection($followers)
        ];
    }

    /**
     * @param $user_id
     * @return array
     */
    #[ArrayShape(['followings' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function followings($user_id): array
    {
        $user = $this->userRepository->findOneById($user_id);
        $followings = $user->followings;
        return [
            'followings' => FollowingResource::collection($followings)
        ];
    }
}
