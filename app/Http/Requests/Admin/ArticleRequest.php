<?php

namespace App\Http\Requests\Admin;

use App\Models\ArticleCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
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
            'catId' => 'required',
            'title' => 'required',
            'text'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'catId.required' => '请选择文章所属类别',
            'title.required' => '文章标题不能为空',
            'image_path.required' => '请上传列表图片',
            'text.required' => '文章内容不能为空',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('image_path', 'required', function ($input) {
            $type = ArticleCategory::where('id', $input->catId)->value('type');
            if ($type == ArticleCategory::TYPE_TEXT_AND_PICTURE_LIST) {
                return true;
            }
        });
    }
}
