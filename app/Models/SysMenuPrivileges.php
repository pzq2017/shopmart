<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysMenuPrivileges extends Model
{
    use SoftDeletes;

    protected $table = 'sys_menus_privileges';

    protected $fillable = ['menuId', 'code', 'name', 'isMenu', 'url', 'otherUrl'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function sysMenu()
    {
    	return $this->belongsTo(SysMenu::class, 'menuId');
    }
}
