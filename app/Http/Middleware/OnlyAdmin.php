<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Models\Admin;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     * @throws CustomException
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (auth()->user() instanceof Admin) {
            return $next($request);
        }
        throw new CustomException(trans('messages.NOT_AUTHORIZED'));
    }
}
