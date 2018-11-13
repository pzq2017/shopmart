<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendLinks extends Model
{
    use SoftDeletes;

    protected $table = 'friend_links';

    protected $fillable = ['name', 'ico', 'link', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
