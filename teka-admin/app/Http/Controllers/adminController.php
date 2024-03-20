<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use App\Http\Resources\AdminResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // public function login(Request $request)
    // {
    //     $admin = Admin::where('email', $request->email)->first();

    //     if (!$admin) {
    //         return response()->json([
    //             "errors" => [
    //                 "message" => [
    //                     "email not found!"
    //                 ]
    //             ]
    //         ], 401);
    //     }

    //     $token = Str::uuid()->toString();
    //     $admin->token = $token;
    //     $admin->save();

    //     // return new AdminResource($admin);
    //     return response()->json([
    //         "success" => "Successfully logged in!",
    //         "token" => $token
    //     ], 200);
    
    //     // return redirect()->away('/')->with('success', 'Berhasil Login!.');
    // }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect('/');
        } else {
            return redirect()->back()->with('error_message', 'Invalid Email or Password');
        }
    }

    public function register(Request $request)
    {
        // cloudinary()->upload(
        //     $request->file('image')->getRealPath(), [
        //     'transformation' => [
        //         'gravity' => 'auto',
        //         'width' => 300,
        //         'height' => 300,
        //         'crop' => 'crop'
        //     ]
        // ])->getSecurePath();

        // $uploadedFile = $request->file('image'); 
        // $result = Cloudinary::upload($uploadedFile->getRealPath(), [
        // 'folder' => 'teka_apps', 
        // 'public_id' => 'image-' . time(),
        // 'overwrite' =>  true,
        // ]);

        // $image = $result->getSecurePath();

        $admin = Admin::create([
            // 'image'         => $image,
            'email'          => $request->email,
            'name'          => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return (new AdminResource($admin))->response()->setStatusCode(201);
    }


    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        return redirect('/login');
    }

    public function viewLogin()
    {
        $pageTitle = 'Teka | Login';

        return view('pages.login.index', compact('pageTitle'));
    }
}
