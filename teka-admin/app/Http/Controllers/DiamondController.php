<?php

namespace App\Http\Controllers;

use App\Models\Diamond;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\DiamondRequest;
use App\Http\Resources\DiamondResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class DiamondController extends Controller
{
    public function createDiamond(DiamondRequest $request): JsonResponse
    {
        $this-> validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png,|max:2048',
            'quantity'=> 'required|numeric',
            'price'=> 'required|numeric',
        ]);

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

        $diamond = Diamond::create([
            'image'         => $image,
            'quantity'      => $request->quantity,
            'price'         => $request->price,
        ]);

        return (new DiamondResource($diamond))->response()->setStatusCode(201);
    }

    public function getDiamond()
    {
        $diamond = Diamond::All();
        return response()->json(['diamonds' => $diamond], 200);
    }

    public function updateDiamond(Request $request, $id)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png,|max:2048',
            'quantity'=> 'required|numeric',
            'price'=> 'required|numeric',
        ]);

        $diamond = Diamond::find($id);

        if(!$diamond){
            return response()->json(['message' => 'Diamond not found'], response::HTTP_NOT_FOUND);
        }

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

        $diamond->update([
            'image' => $image,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return (new DiamondResource($diamond))->response()->setStatusCode(201);
    }

    public function deleteDiamond(Request $request, $id)
    {
        $diamond = Diamond::find ($id);

        if($diamond){
            $diamond->delete();
            return response()->json(['message' => 'Diamond deleted'], Response::HTTP_NOT_FOUND);
        }
    }


     ////////////////////////////////////////////// view //////////////////////////////////////////
     public function index()
    {
        $diamonds = Diamond::all();
        $pageTitle = 'Teka | Diamond';
        $user = Auth::guard('admin')->user();
        
        return view('pages.diamond.view-diamond', compact('diamonds', 'pageTitle'), ['user' => $user]);
    }

     public function viewCreatediamond()
    {
        // $diamonds = diamond::all();
        $pageTitle = 'Teka | Create Diamond';
        $user = Auth::guard('admin')->user();

        return view('pages.diamond.create-diamond', compact('pageTitle'), ['user' => $user]);
    }

     public function adminCreatediamond(diamondRequest $request)
    {
        cloudinary()->upload(
            $request->file('image')->getRealPath()
        )->getSecurePath();

        $uploadedFile = $request->file('image'); 
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
        'folder' => 'teka_apps', 
        'public_id' => 'image-' . time(),
        'overwrite' =>  true,
        ]);

        $image = $result->getSecurePath();

        $diamond = diamond::create([
            'image'         => $image,
            'quantity'   => $request->quantity,
            'price'         => $request->price,
        ]);

        return redirect()->away('/diamond')->with('success', 'Diamond Created!.');
    }

    public function viewEditdiamond($id)
    {

        $diamond = Diamond::find($id);
        $pageTitle = 'Teka | Edit Diamond';
        $user = Auth::guard('admin')->user();

        if (!$diamond) {
            return response()->json(['message' => 'Diamond not found'], Response::HTTP_NOT_FOUND);
        }

        return view('pages.diamond.edit-diamond', compact('diamond', 'pageTitle'), ['user' => $user]);
    }

    public function adminUpdatediamond(diamondRequest $request, $id)
    {
        $diamond = Diamond::find($id);

        if (!$diamond) {
            return response()->json(['message' => 'Diamond not found'], Response::HTTP_NOT_FOUND);
        }

        $uploadedFile = $request->file('image');
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
            'folder' => 'teka_apps',
            'public_id' => 'image-' . time(),
            'overwrite' => true,
        ]);

        $image = $result->getSecurePath();

        $diamond->update([
            'image'         => $image,
            'quantity'      => $request->quantity,
            'price'         => $request->price,
        ]);
        return redirect()->away('/diamond')->with('success', 'Diamond updated successfully!.');
    }

    public function adminDeletevatar($id)
    {
        $diamond = Diamond::find($id);

        if ($diamond) {
            $diamond->delete();
            return redirect()->away('/diamond')->with('success', 'diamond Deleted!.');
        } else {
            return response()->json(['error' => 'diamond not found'], Response::HTTP_NOT_FOUND);
        }
    }

}
