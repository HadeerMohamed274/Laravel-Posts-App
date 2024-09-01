<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            "title" => "required",
            "description" => "required|min:10",
            "image" => "image|mimes:jpeg,jpg,png|max:2048"
        ];
    }

    public function messages(): array
    {
        return [
            "title.required" => "Title is required",
            "description.required" => "Description is required",
            "description.min" => "Description must be at least 10 characters",
            "image.image" => "Image must be an image",
            "image.mimes" => "Image must be a jpeg, jpg or png file",
            "image.max" => "Image size must be less than 2MB",
        ];
    }
}
