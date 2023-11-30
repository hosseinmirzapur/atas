<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ACL
Route::prefix('/acl')->group(function () {
    Route::post('/login', [OtpController::class, 'login']);
    Route::post('/register', [OtpController::class, 'register']);
    Route::post('/confirm-register-otp', [OtpController::class, 'confirmOtp']);
    Route::post('/forget-pass', [OtpController::class, 'forgetPass']);
    Route::post('/confirm-forget-password-code', [OtpController::class, 'confirmForgetPasswordCode']);
    Route::post('/change-pass-from-forget-pass', [OtpController::class, 'changePassFromForgetPass']);
    Route::post('/logout', [OtpController::class, 'logout'])->middleware('auth:sanctum');
});

// Profile
Route::middleware('auth:sanctum')->prefix('/profile')->group(function () {
    Route::post('/', [ProfileController::class, 'store']);
    Route::get('/', [ProfileController::class, 'index']);
    Route::post('/change-password', [ProfileController::class, 'changePassword']);
});

// Follow/Unfollow Process
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/follow', [FollowController::class, 'follow']);
    Route::post('/unfollow', [FollowController::class, 'unfollow']);
    Route::get('/followers/{id}', [FollowController::class, 'followers']);
    Route::get('/followings/{id}', [FollowController::class, 'followings']);
});

// Notification
Route::middleware('auth:sanctum')->prefix('/notification')->group(function () {
    Route::post('/', [NotificationController::class, 'notify'])->middleware('only-admin');
    Route::get('/all', [NotificationController::class, 'allUserNotifications']);
    Route::get('/all-for-admin', [NotificationController::class, 'allForAdmin'])->middleware('only-admin');
    Route::get('/seen', [NotificationController::class, 'seenNotifications']);
    Route::get('/unseen', [NotificationController::class, 'unreadNotifications']);
    Route::post('/mark-as-read', [NotificationController::class, 'markNotificationsAsRead']);
});

// FAQ
Route::prefix('/faq')->group(function () {
    Route::get('/', [FaqController::class, 'showLast']);
    Route::post('/', [FaqController::class, 'createNew'])->middleware('only-admin');
});

// Announcement
Route::prefix('/announcement')->group(function () {
    Route::resource('/', AnnouncementController::class);
});

// Like
Route::middleware('auth:sanctum')->prefix('/like')->group(function () {
    Route::post('/comment', [LikeController::class, 'likeComment']);
    Route::post('/idea', [LikeController::class, 'likeIdeaOrNews']);
    Route::post('/news', [LikeController::class, 'likeIdeaOrNews']);
    Route::post('/message', [LikeController::class, 'likeMessage']);
});

// Comment
Route::middleware('auth:sanctum')->prefix('/comment')->group(function () {
    Route::post('/idea', [CommentController::class, 'onIdeaOrNews']);
    Route::post('/news', [CommentController::class, 'onIdeaOrNews']);
    Route::post('/{commentId}/reply', [CommentController::class, 'reply']);
    Route::put('/update', [CommentController::class, 'update']);
    Route::delete('/{id}/delete', [CommentController::class, 'delete']);
    Route::put('/change-status', [CommentController::class, 'updateStatus'])->middleware('only-admin');
});

// Plan
Route::resource('/plan', PlanController::class);
Route::post('/assign-options', [PlanController::class, 'grantOptionsToPlan']);

// Option
Route::resource('/option', OptionController::class)->middleware('only-admin');

// Bookmark
Route::middleware('auth:sanctum')->prefix('/save')->group(function () {
    Route::post('/coin', [BookmarkController::class, 'coin']);
    Route::post('/strategy', [BookmarkController::class, 'strategy']);
    Route::post('/market', [BookmarkController::class, 'market']);
    Route::post('/idea', [BookmarkController::class, 'ideaOrNews']);
    Route::post('/news', [BookmarkController::class, 'ideaOrNews']);
});

// Remove Bookmark
Route::middleware('auth:sanctum')->prefix('/remove-save')->group(function () {
    Route::delete('/coin/{id}', [BookmarkController::class, 'removeCoinBookmark']);
    Route::delete('/strategy/{id}', [BookmarkController::class, 'removeStrategyBookmark']);
    Route::delete('/market/{id}', [BookmarkController::class, 'removeMarketBookmark']);
    Route::delete('/idea/{id}', [BookmarkController::class, 'removeIdeaOrNews']);
    Route::delete('/news/{id}', [BookmarkController::class, 'removeIdeaOrNews']);
});

// Report
Route::middleware('auth:sanctum')->prefix('/report')->group(function () {
    Route::post('/idea', [ReportController::class, 'ideaOrNews']);
    Route::post('/news', [ReportController::class, 'ideaOrNews']);
    Route::post('/user', [ReportController::class, 'user']);
    Route::post('/comment', [ReportController::class, 'comment']);
    Route::put('/change-status', [ReportController::class, 'changeStatus'])->middleware('only-admin');
    Route::delete('/{id}', [ReportController::class, 'destroy'])->middleware('only-admin');
});

// Website Sliders & Mobile Sliders
Route::resource('/slider', SliderController::class);

// Ideas
Route::middleware('auth:sanctum')->prefix('/idea')->group(function () {
    Route::resource('/', IdeaController::class);
    Route::post('/change-status', [IdeaController::class, 'changeStatus'])->middleware('only-admin');
});

// News
Route::middleware('auth:sanctum')->prefix('/news')->group(function () {
    Route::resource('/', NewsController::class)->middleware('only-admin');
    Route::get('/for-users', [NewsController::class, 'forUsers']);
});

// Payment Methods
Route::prefix('/payment-method')->group(function () {
    Route::resource('/', PaymentMethodController::class);
});

// Networks
Route::middleware('auth:sanctum')->prefix('/network')->group(function () {
    Route::post('/add', [NetworkController::class, 'add']);
    Route::post('/{id}', [NetworkController::class, 'update']);
    Route::delete('/{id}', [NetworkController::class, 'destroy']);
});

// Billing
Route::middleware('auth:sanctum')->prefix('/billing')->group(function () {
    Route::post('/pay', [BillingController::class, 'pay']);
    Route::get('/', [BillingController::class, 'all'])->middleware('only-admin');
    Route::post('/change-status', [BillingController::class, 'changeBillingStatus'])->middleware('only-admin');
});

// Chat
Route::middleware('auth:sanctum')->prefix('/chat')->group(function () {
    Route::post('/create', [ChatController::class, 'create'])->middleware('authorized');
    Route::get('/', [ChatController::class, 'index']);
    Route::delete('/delete/{chatId}', [ChatController::class, 'delete'])->middleware('authorized');
});

// Messages
Route::middleware('auth:sanctum')->prefix('/message')->group(function () {
    Route::resource('/', MessageController::class);
    Route::post('/reply', [MessageController::class, 'reply']);
    Route::post('/forward', [MessageController::class, 'forward']);
    Route::get('/chat/{chat}', [MessageController::class, 'chatMessages']);
});

// Groups
Route::middleware('auth:sanctum')->prefix('/group')->group(function () {
    Route::resource('/', GroupController::class);
});
