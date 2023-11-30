<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Models\UserPlan;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorizedUser
{
    public function handle(Request $request, Closure $next)
    {
//        $user = currentUser();
//        $userPlan = UserPlan::query()->where('user_id', $user->getAttribute('id'))->first();
//        if (!exists($userPlan) && $user->getAttribute('reputation') < 5) {
//            throw new CustomException(trans('UNAUTHORIZED'));
//        }

        return $next($request);
    }
}
