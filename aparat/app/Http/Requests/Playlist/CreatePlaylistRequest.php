<?php

namespace App\Http\Requests\Playlist;

use App\Rules\UniqueTitleForUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreatePlaylistRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'max:20', 'string', new UniqueTitleForUser]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'عنوان نمیتواند خالی باشد',
            'title.min' => 'عنوان نمیتواند کمتر از 3 کاراکتر باشد',
            'title.max' => 'عنوان نمیتواند بیش از 20 کاراکتر باشد',
            'title.string' => 'عنوان باید کاراکتر باشد'
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
