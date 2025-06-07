<?php

namespace App\Http\Requests\Video;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UploadVideoRequest extends FormRequest
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
            'video' => 'required|file|max:20480',
            'slug' => 'required|unique:videos'
        ];
    }

     public function messages()
    {
        return [
            'video.required' => 'ویدیو اجباری است',
            'video.file' => 'ویدیو باید حتما یک فایل باشد',
            'video.max' => 'حجم ویدیو نمیتواند بیش از 20 مگابایت باشد',
            'slug.required' => 'عنوان ویدیو اجباری است',
            'slug.unique' => 'این عنوان قبلا گرفته شده است'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'خطا در اعتبار سنجی',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }
}
