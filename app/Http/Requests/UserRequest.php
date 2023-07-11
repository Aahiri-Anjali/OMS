<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = request()->id;
        if(isset($id))
        {
            return [
                'name' => 'required|unique:customers,name,'.$id,
               'role' => 'required',
             ];

        }else{
            return [
                'email' => 'required|unique:customers,email,'.$id,
                'password' => 'required|min:8',
                'name' => 'required|unique:customers,name,'.$id,
                'role' => 'required',
             ];
        }
       
    }
}
