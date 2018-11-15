<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use SoftDeletes;

    protected $table = 'article_category';

    protected $fillable = ['pid', 'name', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
