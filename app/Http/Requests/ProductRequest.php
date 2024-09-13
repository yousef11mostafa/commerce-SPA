<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
       return[
        'name' => 'required|string|max:255',
        // 'user_id' => 'required|exists:users,id', // Assuming you have categories
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id', // Assuming you have categories
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // For optional image upload
       ];
    }
}
