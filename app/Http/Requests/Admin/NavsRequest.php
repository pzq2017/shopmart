<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NavsRequest extends FormRequest
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
            'type' => 'required|integer',
            'name' => 'required',
            'url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '请选择导航类型',
            'type.integer' => '请选择正确的导航类型',
            'name.required' => '导航名称不能为空',
            'url.required' => '导航链接不能为空',
        ];
    }
}
