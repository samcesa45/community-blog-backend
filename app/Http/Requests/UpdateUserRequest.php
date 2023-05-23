<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'=> 'required|numeric|exists:users,id',
            'username'=> 'required|string|max:100',
            'first_name'=> 'required|string|max:100',
            'last_name'=> 'required|string|max:100',
            'job_title'=> 'nullable|string|max:100',
            'profile_picture_path' => 'nullable|mimes:jpg,png',
            'email' => 'required|unique:users,email'
        ];
    }
}
