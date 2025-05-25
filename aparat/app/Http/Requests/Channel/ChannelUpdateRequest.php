<?php

namespace App\Http\Requests\Channel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ChannelUpdateRequest extends FormRequest
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
            'info' => 'nullable|string|required_without:socials',
            'socials' => 'nullable|string|required_without:info'
        ];
    }

    public function messages()
    {
        return [
            'info.nullable' => 'درباره کانال نمیتواند خالی باشد',
            'info.required_without' => 'درباره کانال اجباری است وقتی شبکه های اجتماعی وارد نشده',
            'info.string' => 'درباره کانال باید رشته متنی باشد',
            'socials.nullable' => 'شبکه های اجتماعی نمیتواند خالی باشد',
            'socials.required_without' => 'شبکه های اجتماعی اجباری است وقتی درباره کانال وارد نشده است',
            'socials.string' => 'شبکه های اجتماعی باید رشته متنی باشد',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'خطای اعتبار سنجی',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }
}
