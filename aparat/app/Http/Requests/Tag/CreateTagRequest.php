<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateTagRequest extends FormRequest
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
            'title' => 'unique:tags,title|string|required|min:3|max:40'
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'عنوان تکراری است',
            'title.required' => 'عنوان نمیتواند خالی باشد',
            'title.min' => 'عنوان حداقل باید 3 کاراکتر باشد',
            'title.max' => 'عنوان نمیتواند بیش از 40 کاراکتر باشد',
            'title.string' => 'عنوان باید یک رشته متنی باشد',
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
