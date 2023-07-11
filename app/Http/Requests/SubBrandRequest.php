<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubBrandRequest extends FormRequest
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
        return [
            'brand_type' => 'required|exists:brands,id',
            'name' => 'required|unique:sub_brand,name,'.$id,
        ];
    }
}
