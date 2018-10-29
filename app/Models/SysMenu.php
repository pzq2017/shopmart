<?php

namespace App\Models;

use App\Models\SysMenuPrivileges;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysMenu extends Model
{
    use SoftDeletes;

    protected $table = 'sys_menus';

    protected $fillable = ['parentId', 'name', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeSysMenus($query, $parentId=0)
    {
        return $query->where('parentId', $parentId);
    }

    public function privileges()
    {
    	return $this->hasMany(SysMenuPrivileges::class, 'menuId');
    }

    public function sys_leftmenu_privilige()
    {
        return $this->hasOne(SysMenuPrivileges::class, 'menuId')->where('isMenu', 1);
    }
}
