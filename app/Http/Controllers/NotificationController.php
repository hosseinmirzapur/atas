<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Services\Classes\Notification\NotificationServiceInterface;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    protected NotificationServiceInterface $service;

    public function __construct(NotificationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param NotificationRequest $request
     * @return JsonResponse
     */
    public function notify(NotificationRequest $request): JsonResponse
    {
        $this->service->notify($request);
        return jsonResponse();
    }

    /**
     * @return JsonResponse
     */
    public function unreadNotifications(): JsonResponse
    {
        return jsonResponse($this->service->unreadNotifications());
    }

    /**
     * @return JsonResponse
     */
    public function seenNotifications(): JsonResponse
    {
        return jsonResponse($this->service->seenNotifications());
    }

    /**
     * @return JsonResponse
     */
    public function markNotificationsAsRead(): JsonResponse
    {
        $this->service->markNotificationsAsRead();
        return jsonResponse();
    }

    /**
     * @return JsonResponse
     */
    public function allUserNotifications(): JsonResponse
    {
        return jsonResponse($this->service->allUserNotifications());
    }

    /**
     * @return JsonResponse
     */
    public function allForAdmin(): JsonResponse
    {
        return jsonResponse($this->service->allForAdmin());
    }
}
