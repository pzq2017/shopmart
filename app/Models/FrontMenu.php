<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrontMenu extends Model
{
    use SoftDeletes;

    protected $table = 'front_menus';

    protected $fillable = ['parentId', 'name', 'url', 'otherUrl', 'isShow', 'type', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    const USER_MENU = 1;

    const MERCHANT_MENU = 2;

    public static function menuTypes()
    {
    	return [
    		self::USER_MENU => '用户菜单',
    		self::MERCHANT_MENU => '商家菜单'
    	];
    }

    public function scopeChildMenu($query, $parentId)
    {
        return $query->where('parentId', $parentId);
    }

    public function scopeTypeOfMenu($query, $type)
    {
        if ($type == 0) {
            return $query;
        } else {
            return $query->where('type', $type);
        }
    }
}
