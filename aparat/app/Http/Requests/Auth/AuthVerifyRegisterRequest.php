<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AuthVerifyRegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'code' => 'required|numeric|digits:6'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'ایمیل اجباری هست',
            'email.email' => 'ایمیل فرمت درستی ندارد',
            'code.required' => 'کد تایید را وارد کنید',
            'code.numeric' => 'کد تایید باید یک عدد باشد',
            'code.digits' => 'کد تایید باید 6 رقمی باشد'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'Validation failed.',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }
}
