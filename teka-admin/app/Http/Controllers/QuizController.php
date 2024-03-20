<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\QuizRequest;
use App\Http\Resources\QuizResource;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function createQuiz(QuizRequest $request): JsonResponse
    {

        $quiz = Quiz::create([
            'question'      => $request->question,
            'answer'         => $request->answer,
        ]);

        return (new QuizResource($quiz))->response()->setStatusCode(201);
    }

    public function getQuiz()
    {
        $quiz = Quiz::All();
        return response()->json(['quiz' => $quiz], 200);
    }

    public function updateQuiz(QuizRequest $request, $id)
    {

        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], response::HTTP_NOT_FOUND);
        }

        $quiz->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return (new QuizResource($quiz))->response()->setStatusCode(201);
    }

    public function deleteQuiz($id)
    {
        $quiz = Quiz::find($id);

        if ($quiz) {
            $quiz->delete();
            return response()->json(['message' => 'Quiz Deleted'], Response::HTTP_NOT_FOUND);
        }
    }



    ////////////////////////////////////////////// view //////////////////////////////////////////
    public function index()
    {
        $quiz = Quiz::all();
        $pageTitle = 'Teka | Quiz';
        $user = Auth::guard('admin')->user();


        return view('pages.quiz.view-quiz', compact('quiz', 'pageTitle'), ['user' => $user]);
    }

    public function viewCreateQuiz()
    {
        // $avatars = Avatar::all();
        $pageTitle = 'Teka | Create Quiz';
        $user = Auth::guard('admin')->user();

        return view('pages.quiz.create-quiz', compact('pageTitle'), ['user' => $user]);
    }

    public function adminCreateQuiz(QuizRequest $request)
    {
        $quiz = Quiz::create([
            'question'   => $request->question,
            'answer'     => $request->answer,
            'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
        ]);

        return redirect()->away('/quiz')->with('success', 'Question Created!.');
    }

    public function viewEditQuiz(Request $request, $id)
    {

        $quiz = Quiz::find($id);
        $pageTitle = 'Teka | Edit Quiz';
        $user = Auth::guard('admin')->user();

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], Response::HTTP_NOT_FOUND);
        }

        // return response()->json(['avatar' => $avatar], Response::HTTP_OK);
        return view('pages.quiz.edit-quiz', compact('quiz', 'pageTitle'), ['user' => $user]);
    }

    public function adminUpdateQuiz(Request $request, $id)
    {

        $quiz = Quiz::find($id);

        $quiz->update([
            'question'   => $request->question,
            'answer'     => $request->answer,
            'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
        ]);

        return redirect()->away('/quiz')->with('success', 'Question Updated!.');
    }

    public function adminDeleteQuiz(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        if ($quiz) {
            $quiz->delete();
            return redirect()->away('/quiz')->with('success', 'Quiz Deleted!.');
        } else {
            return response()->json(['error' => 'Quiz not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
