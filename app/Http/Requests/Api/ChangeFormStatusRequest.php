<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ChangeFormStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_form_id'  => 'required|integer|exists:user_form,id',
            'status'        => 'required|string|in:pending,started,completed'
        ];
    }

    public function messages()
    {
        return [
            'user_form_id.required' => 'User Form Id is required.',
            'status.required'       => 'Status is required.',
            'user_form_id.exists'   => 'User Form Id is not exist.',
            'status.in'             => 'Invalid status'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json([
            // 'errors' => $errors
            'errors' => $validator->errors()->first()
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
