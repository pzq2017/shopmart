<?php

namespace App\Http\Requests\Admin;

use App\Models\FrontMenu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FrontMenuRequest extends FormRequest
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
            'url' => 'required',
            'type' => [
                'required',
                Rule::in([FrontMenu::USER_MENU, FrontMenu::MERCHANT_MENU])
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入菜单名称',
            'url.required' => '请输入菜单链接',
            'type.required' => '请选择菜单类型',
            'type.in' => '请选择正确的菜单类型'
        ];
    }
}
