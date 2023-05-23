<?php 

namespace App\Http\Requests\API;
use App\Http\Requests\AppBaseFormRequest;
use App\Models\User;

class LoginAPIRequest extends AppBaseFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules():array
    {
      return [
          'password' => 'required',
          'email'=> 'required|email'
      ];
    }
}