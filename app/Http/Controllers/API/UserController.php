<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserFormAnswerSubmitRequest;
use App\Http\Requests\Api\UserFormListRequest;
use App\Models\Api\UserAccess;
use App\Models\Api\UserForm;
use App\Models\Api\UserFormAnswers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }

    //user Access List
    public function userAccessList(Request $request)
    {
        try {
            $user = Auth::user();

            $privillages = UserAccess::where(['user_id' => $user->id, 'type' => 'privillege'])->with('privillege')->get();
            $tournaments = UserAccess::where(['user_id' => $user->id, 'type' => 'tournament'])->with('tournament')->get();

            return response()->json([
                'status'        => 200,
                'privillages' => $privillages,
                'tournaments' => $tournaments,
            ]);


            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }


    //user form List
    public function userFormList(UserFormListRequest $request)
    {
        try {
            $user = Auth::user();

            $tournament_id = $request->tournament_id;
            $status = strtolower($request->status);
            $user_forms = UserForm::where(['user_id' => $user->id, 'tournament_id' => $tournament_id, 'status' => $status])->with('form')->get();

            return response()->json([
                'status'        => 200,
                'user_forms' => $user_forms,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }

    //user Form Answer Submit
    public function userFormAnswerSubmit(UserFormAnswerSubmitRequest $request)
    {
        try {
            $user = Auth::user();

            $user_answer_qry = UserFormAnswers::where([
                'user_form_id'  => (int)$request->user_form_id,
                'user_id'       => $user->id,
                'question_id'   => (int)$request->question_id,]);
            
            if($user_answer_qry->exists()) {

                $user_answer = $user_answer_qry->first();
                $user_answers = [
                    'answer'        => $request->answers,
                    'updated_at'    => Carbon::now()->format('Y-m-d')
                ];
                $answer_save = $user_answer->update($user_answers);

            } else {
                $user_answers = [
                    'user_form_id'  => (int)$request->user_form_id,
                    'user_id'       => $user->id,
                    'question_id'   => (int)$request->question_id,
                    'answer'        => $request->answers,
                    'created_at'    => Carbon::now()->format('Y-m-d'),
                    'updated_at'    => Carbon::now()->format('Y-m-d')
                ];
                $answer_save = UserFormAnswers::create($user_answers);
            }

            
            if($answer_save) {
                return response()->json([
                    'status'    => 200,
                    'message'   => 'User answers saved successfully.'
                ]);
            } else {
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Answer not saved!'
                ]);
            }



        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }

}
