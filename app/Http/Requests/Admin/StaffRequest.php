<?php

namespace App\Http\Requests\Admin;

use App\Models\Staffs;
use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'loginName' => 'required',
            'password' => 'max:20',
            'staffName' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'loginName.required' => '请输入职员登录账号.',
            'loginName.unique' => '职员登录账号已存在.',
            'password.required' => '请输入职员登录密码.',
            'password.max' => '职员登录密码最大20位.',
            'staffName.required' => '职员姓名不能为空.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('loginName', 'unique:staffs,loginName', function ($input) {
            if (!isset($input->id)) {
                return true;
            } else {
                $exist = Staffs::where('id', '<>', $input->id)
                                ->where('loginName', $input->loginName)
                                ->count();
                if ($exist) {
                    return true;
                }
            }
        });
        $validator->sometimes('password', 'required', function ($input) {
            if (!isset($input->id)) {
                return true;
            }
        });
    }
}
