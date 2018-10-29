<?php

namespace App\Http\Requests\Admin;

use App\Models\SysMenu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rule;

class MenuRequest extends FormRequest
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
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入菜单名称',
            'name.unique' => '菜单名称已存在',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('name', 'unique:sys_menus', function ($input) {
            $query = SysMenu::where('parentId', $input->parentId)->where('name', $input->name);
            if ($input->id == 0) {
                $exist = $query->count();
            } else {
                $exist = $query->where('id', '<>', $input->id)->count();
            }
            return $exist > 0;
        });
    }
}
