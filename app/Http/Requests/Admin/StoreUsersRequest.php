<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request()->roles[0] == "User"){
            return [
                'name' => 'required|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|regex:/^(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',
                'roles' => 'required'
            ];
        }else{
            return [
                'name' => 'required|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|regex:/^(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',
                'roles' => 'required'
            ];
        }
    }

    public function messages()
    {
        return [
            'password.regex' => 'The password must have a letter and number',
        ];
    }
}
