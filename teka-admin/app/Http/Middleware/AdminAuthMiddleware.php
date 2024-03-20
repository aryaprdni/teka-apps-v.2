<?php

namespace App\Http\Middleware;

// use App\Models\Admin;
// use Closure;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Response;

// class AdminAuthMiddleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {
//         $token = $request->bearerToken();

//         if (!$token) {
//             return response()->json([
//                 "errors" => [
//                     "message" => [
//                         "Unauthorized"
//                     ]
//                 ]
//             ])->setStatusCode(401);
//         }

//         $admin = Admin::where('token', $token)->first();
//         if (!$admin) {
//             return response()->json([
//                 "errors" => [
//                     "message" => [
//                         "Unauthorized"
//                     ]
//                 ]
//             ])->setStatusCode(401);
//         } 
//         Auth::guard('admin')->login($admin);

//         return $next($request);
//     }
// }


use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            // return response()->json([
            //     'error' => 'Unauthorized'
            // ], 401);
            return redirect('/login');
        }

        return $next($request);
    }
}