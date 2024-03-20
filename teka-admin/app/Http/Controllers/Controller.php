<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\Quiz;
use App\Models\Diamond;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


        public function index()
    {

        $user = Auth::guard('admin')->user();
        
        $avatarCount = Avatar::count();
        $quizCount = Quiz::count();
        $diamondCount = Diamond::count();
        // $paymentCount = Payment::count();
        $userCount = User::count();
        $pageTitle = 'Teka | Dashboard';

        return view('index', compact('pageTitle'), ['user' => $user, 'avatarCount' => $avatarCount, 'quizCount' => $quizCount, 'diamondCount' => $diamondCount, 
        // 'paymentCount' => $paymentCount, 
        'userCount' => $userCount]);
    }
}
