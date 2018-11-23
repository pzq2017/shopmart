<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use SoftDeletes;

    protected $table = 'article_category';

    protected $fillable = ['pid', 'type', 'name', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    const TYPE_SINGLE = 1;                      //单页
    const TYPE_TEXT_LIST = 2;                   //文字列表
    const TYPE_TEXT_AND_PICTURE_LIST = 3;       //图文列表
    const CATEGORY_TYPES = [
        self::TYPE_SINGLE,
        self::TYPE_TEXT_LIST,
        self::TYPE_TEXT_AND_PICTURE_LIST
    ];

    public function scopePublishCategory($query)
    {
        return $query->where('status', 1);
    }

    public function scopeCategoryByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public static function getType($id)
    {
        return self::where('id', $id)->value('type');
    }
}
