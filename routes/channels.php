<?php

use App\Exceptions\CustomException;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat.{chat}', function ($model, Chat $chat) {
    if (!($model instanceof User)) {
        throw new CustomException(trans('messages.UNAUTHORIZED_ACCESS_TO_SOCKET'));
    }
    $user = $model;
    return
        (int)$chat->getAttribute('user_id') === (int)$user->getAttribute('id')
        ||
        (int)$chat->getAttribute('endpoint_user_id') === (int)$user->getAttribute('id');
});
