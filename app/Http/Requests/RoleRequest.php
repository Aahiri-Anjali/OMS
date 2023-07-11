<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RoleRequest extends FormRequest
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
    public function rules(Request $request)
    {
        if (isset($request->id)) {
            $id = Crypt::decryptString(request()->id);
            return [
                'name' => 'required|unique:roles,name,' . $id,
                'permission' => 'requierd',
            ];
        } else {
            return [
                'name' => 'required|unique:roles,name',
                'permission' => 'requierd',
            ];
        }
    }
}
