<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        // var_dump($data);
        if (User::where('name', $data['name'])->count() > 0) {
            throw new HttpResponseException(response([
                "errors" => [
                    "name" => [
                        "name already registered"
                    ]
                ]
            ], 400));
        }

        $user = new User();

        // ini cloudinary
        // if ($request->hasFile('avatar')) {
        //     $avatarFile = $request->file('avatar');

        //     try {
        //         $cloudinaryUpload = Cloudinary::upload($avatarFile->getRealPath(), [
        //             'folder' => 'teka_apps',
        //             'public_id' => 'image_' . time(),
        //             'overwrite' => true,
        //         ]);

        //         $data['avatar'] = $cloudinaryUpload->getSecurePath();
        //     } catch (\Throwable $e) {
        //         report($e);

        //         throw new HttpResponseException(
        //             response(['message' => 'There was an error uploading the file'], 500)
        //         );
        //     }
        // }

        if ($request->hasFile('purchasedAvatars')) {
            $data['purchasedAvatars'] = [];

            foreach ($request->file('purchasedAvatars') as $file) {
                try {
                    $cloudinaryUpload = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'teka_apps',
                        'public_id' => 'image_' . time(),
                        'overwrite' => true,
                    ]);

                    // Menyimpan URL avatar yang diunggah dalam array $purchasedAvatarsUrls
                    $data['purchasedAvatars'][]['avatar'] = $cloudinaryUpload->getSecurePath();
                } catch (\Throwable $e) {
                    report($e);

                    throw new HttpResponseException(
                        response(['message' => 'There was an error uploading the file'], 500)
                    );
                }
            }
        }



        $user->fill($data);

        try {
            $user->save();
        } catch (\Throwable $e) {
            report($e);

            throw new HttpResponseException(
                response(['message' => 'Error saving data: ' . $e->getMessage()], 500)
            );
        }


        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function login(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "email not found!"
                    ]
                ]
            ], 401));
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }

    public function get(Request $request): UserResource
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request): UserResource
    {
        $data = $request->validated();
        $user = Auth::user();

        if (!$user instanceof User) {
            throw new HttpResponseException(response(['message' => 'User not found'], 404));
        }

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        try {
            if ($request->hasFile('avatar')) {
                // Upload file avatar ke Cloudinary dan simpan URL-nya di dalam model User
                $avatarFile = $request->file('avatar');
                $cloudinaryUpload = Cloudinary::upload($avatarFile->getRealPath(), [
                    'folder' => 'teka_apps',
                    'public_id' => 'avatar_' . time(),
                    'overwrite' => true,
                ]);
                $user->avatar = $cloudinaryUpload->getSecurePath();
            }

            if ($request->hasFile('purchasedAvatars')) {
                // Upload file purchasedAvatars ke Cloudinary dan simpan URL-nya di dalam model User sebagai array string
                $purchasedAvatarFiles = $request->file('purchasedAvatars');
                $purchasedAvatarsUrls = [];
                foreach ($purchasedAvatarFiles as $file) {
                    $cloudinaryUpload = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'teka_apps',
                        'public_id' => 'purchased_avatar_' . time(),
                        'overwrite' => true,
                    ]);
                    $purchasedAvatarsUrls[] = $cloudinaryUpload->getSecurePath();
                }
                $user->purchasedAvatars = $purchasedAvatarsUrls;
            }

            $user->save();

            return new UserResource($user);
        } catch (\Throwable $e) {
            report($e);
            throw new HttpResponseException(response(['message' => 'Error updating user: ' . $e->getMessage()], 500));
        }
    }




    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            throw new HttpResponseException(response(['message' => 'User not found'], 404));
        }

        $user->token = null;

        try {
            $user->save();
        } catch (\Throwable $e) {
            report($e);

            throw new HttpResponseException(
                response(['message' => 'Error saving data: ' . $e->getMessage()], 500)
            );
        }

        return response()->json([
            "data" => true
        ])->setStatusCode(200);
    }



    //////////////////////////////////// VIEW /////////////////////////////////////////////////////

    public function index()
    {
        $users = User::all();
        $pageTitle = 'Teka | User';
        $user = Auth::guard('admin')->user();

        return view('pages.user.view-user', compact('users', 'pageTitle'), ['user' => $user]);
    }


    public function viewCreateUser()
    {
        // $users = user::all();
        $pageTitle = 'Teka | Create User';
        $user = Auth::guard('admin')->user();
        return view('pages.user.create-user', compact('pageTitle'), ['user' => $user]);
    }

    public function adminCreateUser(UserRequest $request)
    {
        cloudinary()->upload(
            $request->file('image')->getRealPath(),
            [
                'transformation' => [
                    'gravity' => 'auto',
                    'width' => 300,
                    'height' => 300,
                    'crop' => 'crop'
                ]
            ]
        )->getSecurePath();

        $uploadedFile = $request->file('image');
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
            'folder' => 'teka_apps',
            'public_id' => 'image-' . time(),
            'overwrite' =>  true,
        ]);

        $image = $result->getSecurePath();

        $user = user::create([
            'image'         => $image,
            'user_name'   => $request->user_name,
            'price'         => $request->price,
            // 'status'        => $request->status,
        ]);

        return redirect()->away('/user')->with('success', 'user Created!.');
    }

    public function viewEditUser($id)
    {
        $pageTitle = 'Teka | Edit user';

        try {
            $user = User::findOrFail($id);
            $user = Auth::guard('admin')->user();

            if (!$user) {
                throw new \Exception('User not found');
            }

            return view('pages.user.edit-user', compact('user', 'pageTitle'), ['user' => $user]);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }



    public function adminUpdateUser(userRequest $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            report(new \Exception('User not found'));
            return response()->json(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
        }

        try {
            $uploadedFile = $request->file('image');
            if (is_null($uploadedFile)) {
                throw new \Exception('Uploaded file is null');
            }
            $result = Cloudinary::upload($uploadedFile->getRealPath(), [
                'folder' => 'teka_apps',
                'public_id' => 'image-' . time(),
                'overwrite' => true,
            ]);

            $image = $result->getSecurePath();

            $user->update([
                'image' => $image,
                'user_name' => $request->user_name,
                'price' => $request->price,
                // 'status' => $request->status,
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return redirect()->away('/user')->with('success', 'user updated successfully!.');
    }


    public function adminDeleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return redirect()->away('/user')->with('success', 'user Deleted!.');
        } else {
            return response()->json(['error' => 'user not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
