<?php

namespace App\Http\ViewComposers;

use App\Models\SysMenu;
use Illuminate\View\View;

class AdminComposer
{
    public function compose(View $view)
    {
        $menus = SysMenu::sysMenus(0)->orderBy('sort', 'asc')->get();
        $base = [
            'header_menus' => $menus,
        ];
        $view->with('base', $base);
    }
}