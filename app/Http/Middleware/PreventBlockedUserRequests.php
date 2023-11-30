<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PreventBlockedUserRequests
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     * @throws CustomException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->has('Authorization') && currentUser()->isBlocked()) {
            throw new CustomException(trans('messages.BLOCKED_USER'));
        }
        return $next($request);
    }
}
