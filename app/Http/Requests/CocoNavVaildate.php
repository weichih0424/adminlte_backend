<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CocoNavVaildate extends FormRequest
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
            'url' => 'exclude_if:position,1|required|url|active_url', //若position為1時不進行驗證
        ];
    }

    public function attributes()
    {
        return [
            'name' => '類別名稱',
            'url' => '網址',
        ];
    }
}
