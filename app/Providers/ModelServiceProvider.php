<?php

namespace App\Providers;

use App\Services\Classes\Announcement\AnnouncementService;
use App\Services\Classes\Announcement\AnnouncementServiceInterface;
use App\Services\Classes\Billing\BillingService;
use App\Services\Classes\Billing\BillingServiceInterface;
use App\Services\Classes\Bookmark\BookmarkService;
use App\Services\Classes\Bookmark\BookmarkServiceInterface;
use App\Services\Classes\Chat\ChatService;
use App\Services\Classes\Chat\ChatServiceInterface;
use App\Services\Classes\Comment\CommentService;
use App\Services\Classes\Comment\CommentServiceInterface;
use App\Services\Classes\FAQ\FaqService;
use App\Services\Classes\FAQ\FaqServiceInterface;
use App\Services\Classes\Follow\FollowService;
use App\Services\Classes\Follow\FollowServiceInterface;
use App\Services\Classes\Group\GroupService;
use App\Services\Classes\Group\GroupServiceInterface;
use App\Services\Classes\Idea\IdeaService;
use App\Services\Classes\Idea\IdeaServiceInterface;
use App\Services\Classes\Like\LikeService;
use App\Services\Classes\Like\LikeServiceInterface;
use App\Services\Classes\Message\MessageService;
use App\Services\Classes\Message\MessageServiceInterface;
use App\Services\Classes\Network\NetworkService;
use App\Services\Classes\Network\NetworkServiceInterface;
use App\Services\Classes\News\NewsService;
use App\Services\Classes\News\NewsServiceInterface;
use App\Services\Classes\Notification\NotificationService;
use App\Services\Classes\Notification\NotificationServiceInterface;
use App\Services\Classes\Option\OptionService;
use App\Services\Classes\Option\OptionServiceInterface;
use App\Services\Classes\Otp\OtpService;
use App\Services\Classes\Otp\OtpServiceInterface;
use App\Services\Classes\PaymentMethod\PaymentMethodService;
use App\Services\Classes\PaymentMethod\PaymentMethodServiceInterface;
use App\Services\Classes\Plan\PlanService;
use App\Services\Classes\Plan\PlanServiceInterface;
use App\Services\Classes\Profile\ProfileService;
use App\Services\Classes\Profile\ProfileServiceInterface;
use App\Services\Classes\Report\ReportService;
use App\Services\Classes\Report\ReportServiceInterface;
use App\Services\Classes\Slider\SliderService;
use App\Services\Classes\Slider\SliderServiceInterface;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    public $singletons = [
        OtpServiceInterface::class => OtpService::class,
        ProfileServiceInterface::class => ProfileService::class,
        NotificationServiceInterface::class => NotificationService::class,
        FaqServiceInterface::class => FaqService::class,
        AnnouncementServiceInterface::class => AnnouncementService::class,
        LikeServiceInterface::class => LikeService::class,
        CommentServiceInterface::class => CommentService::class,
        PlanServiceInterface::class => PlanService::class,
        OptionServiceInterface::class => OptionService::class,
        BookmarkServiceInterface::class => BookmarkService::class,
        ReportServiceInterface::class => ReportService::class,
        SliderServiceInterface::class => SliderService::class,
        IdeaServiceInterface::class => IdeaService::class,
        NewsServiceInterface::class => NewsService::class,
        PaymentMethodServiceInterface::class => PaymentMethodService::class,
        NetworkServiceInterface::class => NetworkService::class,
        BillingServiceInterface::class => BillingService::class,
        FollowServiceInterface::class => FollowService::class,
        ChatServiceInterface::class => ChatService::class,
        MessageServiceInterface::class => MessageService::class,
        GroupServiceInterface::class => GroupService::class
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
