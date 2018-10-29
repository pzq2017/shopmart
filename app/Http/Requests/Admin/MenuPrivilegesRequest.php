<?php

namespace App\Http\Requests\Admin;

use App\Models\SysMenuPrivileges;
use Illuminate\Foundation\Http\FormRequest;

class MenuPrivilegesRequest extends FormRequest
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
            'name' => 'required|max:20',
            'code' => 'required|max:20',
            'menuId' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入权限名称',
            'name.max' => '权限名称不能超过20个字符',
            'code.required' => '请输入权限代码',
            'code.max' => '权限代码不能超过20个字符',
            'code.unique' => '权限代码不能重复',
            'menuId.required' => '无效的权限菜单',
            'menuId.integer' => '无效的权限菜单'
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('code', 'unique:sys_menus_privileges,code', function ($input) {
            if ($input->id > 0) {
                $exist = SysMenuPrivileges::where('code', $input->code)
                    ->where('id', '<>', $input->id)->count();
                if ($exist) return true;
                return false;
            }
            return true;
        });
    }
}
