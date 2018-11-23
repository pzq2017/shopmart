<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'article';

    protected $fillable = ['catid', 'title', 'text', 'sort', 'image_path', 'desc', 'author'];

    protected $dates = ['pub_date', 'created_at', 'updated_at', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'catid');
    }
}
