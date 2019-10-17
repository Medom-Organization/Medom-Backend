<?php

namespace Medom\Http\Middleware;

use Closure;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if ($user->role->name == 'superadmin') {
            return $next($request);
        }else{
        return response()->json(['success' => false, 'error' =>'Access Denied'], 401);
        }
    }
}
