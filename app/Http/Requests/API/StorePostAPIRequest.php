<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Requests\AppBaseFormRequest;


class StorePostAPIRequest extends AppBaseFormRequest
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
            'title' => 'required|string|max:100',
            'body'=> 'required|string|max:1000'
        ];
    }
}
