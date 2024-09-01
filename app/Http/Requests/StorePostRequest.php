<?php

namespace App\Http\Requests;

use App\Rules\MaxPostsRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            "title" => [
                "required",
                "min:3",
                "unique:posts,title",
                new MaxPostsRule(3)
            ],
            "description" => "required|min:10",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "creator_id" => [
                'required',
                'exists:creators,id'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            "title.required" => "Title is required",
            "title.min" => "Title must be at least 3 characters",
            "title.unique" => "Title must be unique",
            "description.required" => "Description is required",
            "description.min" => "Description must be at least 10 characters",
            "creator_id.required" => "Creator is required",
            "creator_id.exists" => "Creator does not exist",
        ];
    }
}
