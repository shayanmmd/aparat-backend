<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AuthRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please provide your email address.',
            'email.email' => 'The email address must be a valid email format.',
            'password.required' => 'A password is required.',
            'password.min' => 'The password must be at least 8 characters long.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        $response = response()->json([
            'success' => false,
            'errors' => $validator->errors(),  
            'message' => 'Validation failed.',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }
}
