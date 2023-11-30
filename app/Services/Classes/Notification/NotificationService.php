<?php


namespace App\Services\Classes\Notification;


use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Repository\Structure\UserRepository;
use JetBrains\PhpStorm\ArrayShape;

class NotificationService implements NotificationServiceInterface
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param NotificationRequest $request
     */
    public function notify(NotificationRequest $request)
    {
        $user = $this->userRepository->findOneById($request->user_id);
        $user->sendNotification($request->title, $request->text);
    }

    /**
     * @return array
     */
    #[ArrayShape(['notifications' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function unreadNotifications(): array
    {
        $user = currentUser();
        $unReadNotifications = $user->unreadNotifications()->get();
        return [
            'notifications' => NotificationResource::collection($unReadNotifications)
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['notifications' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function seenNotifications(): array
    {
        $user = currentUser();
        $seenNotifications = $user->readNotifications()->get();
        return [
            'notifications' => NotificationResource::collection($seenNotifications)
        ];
    }

    public function markNotificationsAsRead()
    {
        currentUser()->unreadNotifications()->update([
            'read_at' => now()
        ]);
    }

    /**
     * @return array
     */
    #[ArrayShape(['notifications' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function allUserNotifications(): array
    {
        return [
            'notifications' => NotificationResource::collection(currentUser()->notifications()->get())
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['notifications' => "\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection"])] public function allForAdmin(): array
    {
        return [
            'notifications' => Notification::query()->get()
        ];
    }
}
