<?php

namespace App\Http\Requests\Video;

use App\Models\Video;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class VideoChangeStateRequest extends FormRequest
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
        $states = Video::CONFIRMED . ',' . Video::BLOCKED;

        return [
            'slug' => 'required',
            'state' => 'in:' . $states
        ];
    }

    public function messages()
    {
        return [
            'slug.required' => 'فیلد اسلاگ نمیتواند خالی باشد',
            'state.in' => 'فیلد وضعیت یا این نام وجود ندارد',
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
