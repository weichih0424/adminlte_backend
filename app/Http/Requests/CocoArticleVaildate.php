<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CocoArticleVaildate extends FormRequest
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
            'intro' => 'required|min:1|max:40',
            'url' => 'required|url|active_url',
            'image' => function ($attribute, $value, $fail) {
                if($value=='[]' || $value==''){
                    return $fail('『圖片』為必填');
                }
            },
            'fb_url' => 'nullable|url|active_url',
            'yt_url' => 'nullable|url|active_url',
            'line_url' => 'nullable|url|active_url',
            'ig_url' => 'nullable|url|active_url',
        ];
    }
    
    public function attributes()
    {
        return [
            'name' => '節目名稱',
            'intro' => '節目簡介',
            'url' => '網址',
            'fb_url' => 'FB連結',
            'yt_url' => 'YT連結',
            'line_url' => 'LINE連結',
            'ig_url' => 'IG連結',
        ];
    }
}
