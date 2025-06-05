<?php

namespace App\Http\Requests\Video;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateVideoRequest extends FormRequest
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
            "category-id" => 'required|integer|exists:categories,id',
            "slug" => 'required|string|max:70',
            "title" => 'required|string|max:50',
            "info" => 'nullable|string',
            "duration" => 'required|integer',
            "banner" => 'nullable|url',
            "publish-at" => 'nullable|date'
        ];
    }

    public function messages()
    {
        return [
            'category-id.required' => 'فیلد دسته بندی اجباری است',
            'category-id.integer' => 'فیلد دسته بندی باید یک عدد باشد',
            'category-id.exists' => 'فیلد دسته بندی باید در جدول مربوطه وجود داشته باشد',
            'slug.required' => 'فیلد شعار اجباری است',
            'slug.string' => 'فیلد شعار باید رشته باشد',
            'slug.max' => 'فیلد شعار نمیتواند بیش از 70 کاراکتر باشد',
            'title.required' => 'عنوان اجباری است',
            'title.string' => 'عنوان باید رشته متنی باشد',
            'title.max' => 'عنوان نمیتواند بیش از 50 کاراکتر باشد',
            'info.string' => 'اطلاعات باید رشته باشد',
            'duration.required' => 'مدت زمان اجباری است',
            'duration.integer' => 'مدت زمان بایدد یک عدد باشد',
            'banner.url' => 'بنر باید یک ادرس وب سایت باشد',
            'publish-at.date' => 'زمان انتشار باید یک تاریخ معتبر باشد'
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
