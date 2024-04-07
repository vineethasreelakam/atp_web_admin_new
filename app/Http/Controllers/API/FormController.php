<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangeFormStatusRequest;
use App\Models\FormQuestions;
use App\Models\Api\UserForm;
use App\Models\UserFormAnswers;
use App\Models\UserFormEditedUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['adminFormQuestions']]);
    }

    //user form List
    public function formQuestions(Request $request)
    {
        try {
            $user = Auth::user();

            $form_id = $request->form_id;
            $user_form_id = $request->user_form_id;
            $status = strtolower($request->status);
            $form_questions = FormQuestions::where(['form_id' => $form_id])
            ->with(['question_type', 'section', 'form', 'question_values', 'question_rules'])->get();

            if ($user_form_id) {
                foreach ($form_questions as $question) {
                    $question->user_answer = UserFormAnswers::where('question_id', $question->id)
                        ->where('user_form_id', $user_form_id)
                        ->where('user_id', $user->id)
                        ->first();
                }
            }

            return response()->json([
                'status'            => 200,
                'form_questions'    => $form_questions
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'message'   => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code'      => $th->getCode(),
            ]);
        }
    }


    //user Form status update
    public function changeFormStatus(ChangeFormStatusRequest $request)
    {
        try {
            $user = Auth::user();

            $user_form = UserForm::where('id', $request->user_form_id)->first();
            if($user_form) {
                $data = $request->except(['user_form_id']);
                $update_data = $user_form->update($data);

                if($update_data) {
                    return response()->json([
                        'status'    => 200,
                        'message'   => 'User form status updated successfully.'
                    ]);
                } else {
                    return response()->json([
                        'status'    => 200,
                        'message'   => 'User form status update failed!'
                    ]);
                }

            } else {
                return response()->json([
                    'status'    => 200,
                    'message'   => 'User form not found!'
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


    public function adminFormQuestions(Request $request)
    {
        try {

            $form_id = $request->form_id;
            $user_form_id = $request->user_form_id;
            $user_id = $request->user_id;
            $edited_by = $request->edited_by;
            $form_questions = FormQuestions::where(['form_id' => $form_id])
            ->with(['question_type', 'section', 'form', 'question_values', 'question_rules'])->get();

            if ($user_form_id) {
                foreach ($form_questions as $question) {
                    $question->user_answer = UserFormAnswers::where('question_id', $question->id)
                        ->where('user_form_id', $user_form_id)
                        ->where('user_id', $user_id)
                        ->first();
                }
            }

            //Update form edit
            // $edit_data = [
            //     'user_form_id'  => $user_form_id,
            //     'edited_by'     => $edited_by,
            //     'date'          => Carbon::now()->format('Y-m-d')
            // ];
            // UserFormEditedUsers::create($edit_data);

            return response()->json([
                'status'            => 200,
                'form_questions'    => $form_questions
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'message'   => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code'      => $th->getCode(),
            ]);
        }
    }


}
