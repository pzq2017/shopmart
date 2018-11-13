<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FriendLinksRequest extends FormRequest
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
            'name' => 'required',
            'image_path' => 'required',
            'link' => 'sometimes|url'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '友情链接名称不能为空',
            'image_path.required' => '请上传友情链接图标',
            'link.url' => '请输入有效的链接网址',
        ];
    }
}
