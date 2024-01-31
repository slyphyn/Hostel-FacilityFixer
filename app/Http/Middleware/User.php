<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info("Middleware: " . get_class($this));

        if(!Auth::check()){
            return redirect('/login');
        }

        $user=Auth::user();
        if($user->role==1){
            return $next($request);
        }

        $user=Auth::user();
        if($user->role==2){
            return redirect('/staff');
        }

        $user=Auth::user();
        if($user->role==3){
            return redirect('/admin');
        }    }
}
