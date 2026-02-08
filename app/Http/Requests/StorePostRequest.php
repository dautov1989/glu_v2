<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // API key middleware handles authorization
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:100',
            'excerpt' => 'nullable|string|max:500',
            'image_url' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Category ID is required',
            'category_id.exists' => 'The selected category does not exist',
            'title.required' => 'Title is required',
            'title.min' => 'Title must be at least 3 characters',
            'content.required' => 'Content is required',
            'content.min' => 'Content must be at least 100 characters',
            'image_url.url' => 'Image URL must be a valid URL',
        ];
    }
}
