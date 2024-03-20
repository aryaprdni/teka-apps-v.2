<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AvatarRequest;
use App\Http\Resources\AvatarResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AvatarController extends Controller
{

    // API
    public function CreateAvatar(AvatarRequest $request): JsonResponse
    {
        cloudinary()->upload(
            $request->file('image')->getRealPath(), [
            'transformation' => [
                'gravity' => 'auto',
                'width' => 300,
                'height' => 300,
                'crop' => 'crop'
            ]
        ])->getSecurePath();

        $uploadedFile = $request->file('image'); 
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
        'folder' => 'teka_apps', 
        'public_id' => 'image-' . time(),
        'overwrite' =>  true,
        ]);

        $image = $result->getSecurePath();

        $avatar = Avatar::create([
            'image'         => $image,
            'avatar_name'   => $request->avatar_name,
            'price'         => $request->price,
            'status'        => $request->status,
        ]);

        return (new AvatarResource($avatar))->response()->setStatusCode(201);
    }

    public function getAllAvatar()
    {

        $avatars = Avatar::all();
    
        return response()->json(['avatars' => $avatars], 200);
    }

    public function updateAvatar(AvatarRequest $request, $id)
    {
        $avatar = Avatar::find($id);

        if (!$avatar) {
            return response()->json(['message' => 'Avatar not found'], Response::HTTP_NOT_FOUND);
        }

        $uploadedFile = $request->file('image');
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
            'folder' => 'teka_apps',
            'public_id' => 'image-' . time(),
            'overwrite' => true,
        ]);

        $image = $result->getSecurePath();

        $avatar->update([
            'image' => $image,
            'avatar_name' => $request->avatar_name,
            'price' => $request->price,
            // 'status' => $request->status,
        ]);

        return (new AvatarResource($avatar))->response()->setStatusCode(201);
    }

    public function deleteAvatar( $id)
    {
        $avatar = Avatar::find($id);

        if ($avatar) {
            $avatar->delete();
            return response()->json(['message' => 'Avatar deleted'], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Avatar not found'], Response::HTTP_NOT_FOUND);
        }
    }

    ////////////////////////////////////////////// view //////////////////////////////////////////
     public function index()
    {
        $avatars = Avatar::all();
        $pageTitle = 'Teka | Avatar';
        $user = Auth::guard('admin')->user();
        
        return view('pages.avatar.view-avatar', compact('avatars', 'pageTitle'), ['user' => $user]);
    }

     public function viewCreateAvatar()
    {
        // $avatars = Avatar::all();
        $user = Auth::guard('admin')->user();
        $pageTitle = 'Teka | Create Avatar';

        return view('pages.avatar.create-avatar', compact('pageTitle'), ['user' => $user]);
    }

     public function adminCreateAvatar(AvatarRequest $request)
    {
        cloudinary()->upload(
            $request->file('image')->getRealPath(), [
            'transformation' => [
                'gravity' => 'auto',
                'width' => 300,
                'height' => 300,
                'crop' => 'crop'
            ]
        ])->getSecurePath();

        $uploadedFile = $request->file('image'); 
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
        'folder' => 'teka_apps', 
        'public_id' => 'image-' . time(),
        'overwrite' =>  true,
        ]);

        $image = $result->getSecurePath();

        $avatar = Avatar::create([
            'image'         => $image,
            'avatar_name'   => $request->avatar_name,
            'price'         => $request->price,
            // 'status'        => $request->status,
        ]);

        return redirect()->away('/avatar')->with('success', 'Avatar Created!.');
    }

    public function viewEditAvatar($id)
    {

        $avatar = Avatar::find($id);
        $pageTitle = 'Teka | Edit Avatar';
        $user = Auth::guard('admin')->user();

        if (!$avatar) {
            return response()->json(['message' => 'Avatar not found'], Response::HTTP_NOT_FOUND);
        }

        return view('pages.avatar.edit-avatar', compact('avatar', 'pageTitle'), ['user'=>$user]);
    }

    public function adminUpdateAvatar(AvatarRequest $request, $id)
    {
        $avatar = Avatar::find($id);

        if (!$avatar) {
            return response()->json(['message' => 'Avatar not found'], Response::HTTP_NOT_FOUND);
        }

        $uploadedFile = $request->file('image');
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
            'folder' => 'teka_apps',
            'public_id' => 'image-' . time(),
            'overwrite' => true,
        ]);

        $image = $result->getSecurePath();

        $avatar->update([
            'image' => $image,
            'avatar_name' => $request->avatar_name,
            'price' => $request->price,
            // 'status' => $request->status,
        ]);
        return redirect()->away('/avatar')->with('success', 'Avatar updated successfully!.');
    }

    public function adminDeletevatar($id)
    {
        $avatar = Avatar::find($id);

        if ($avatar) {
            $avatar->delete();
            return redirect()->away('/avatar')->with('success', 'Avatar Deleted!.');
        } else {
            return response()->json(['error' => 'Avatar not found'], Response::HTTP_NOT_FOUND);
        }
    }

}






