<?php

namespace App\Http\Requests\Admin;

use App\Models\ArticleCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleCategoryRequest extends FormRequest
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
            'type' => [
                'required',
                Rule::in(ArticleCategory::CATEGORY_TYPES)
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '类别名称不能为空',
            'type.required' => '请选择分类类型',
            'type.in' => '请选择正确的分类类型'
        ];
    }
}
