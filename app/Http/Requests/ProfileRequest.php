<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
       $rules=[
            //
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'. auth()->user()->id,
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip_code' => 'required',

        ];

        // if($this->has("image")){
        //     $rules['image']='required|image|mimes:jpeg,png,jpg,gif|max:2048';
        // }

        return $rules;
    }
}
