<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CocoCategoryVaildate extends FormRequest
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
        return [
            'name' => 'required|min:1|max:50',
            'url' => 'required',
        ];
    }
    
    public function attributes()
    {
        return [
            'name' => '節目名稱',
            'url' => '分類路徑',
        ];
    }
}
