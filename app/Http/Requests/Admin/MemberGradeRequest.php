<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MemberGradeRequest extends FormRequest
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
            'icon' => 'required',
            'min_score' => 'required|numeric',
            'max_score' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '会员等级名称不能为空',
            'icon.required' => '请上传会员等级图标',
            'min_score.required' => '请输入处于当前会员等级的下限积分',
            'min_score.numeric' => '下限积分输入不合法',
            'max_score.required' => '请输入处于当前会员等级的上限积分',
            'max_score.numeric' => '上限积分输入不合法',
        ];
    }
}
