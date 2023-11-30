<?php

namespace App\Services\Classes\Notification;

use App\Http\Requests\NotificationRequest;

interface NotificationServiceInterface
{
    /**
     * @param NotificationRequest $request
     */
    public function notify(NotificationRequest $request);

    /**
     * @return array
     */
    public function unreadNotifications(): array;

    /**
     * @return array
     */
    public function seenNotifications(): array;

    public function markNotificationsAsRead();

    /**
     * @return array
     */
    public function allUserNotifications(): array;

    public function allForAdmin();
}
