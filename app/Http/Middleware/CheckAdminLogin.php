<?php

namespace App\Http\Middleware;

use App\Utilities\Constant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //neu chua dang nhap : chuyen huong toi trang dang nhap
        if(Auth::guest()){
            return redirect()->guest('admin/login');
        }
        // neu da dang nhap , nhung sai level: dang xua va dang nhap lao

        if(Auth::user()->level != Constant::user_level_host && Auth::user()->level != Constant::user_level_admin){
            Auth::logout();
            return redirect()->guest('admin/login');
        }

        return $next($request);
    }
}
