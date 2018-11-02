<?php

namespace App\Http\ViewComposers;

use App\Models\SysMenu;
use Illuminate\View\View;

class AdminComposer
{
    public function compose(View $view)
    {
        $header_menus = SysMenu::sysMenusByPid(0)->orderBy('sort', 'asc')->get();
        $header_menu_id = SysMenu::sysMenusByUrl(\Request::url())->value('id');

        $subMenus = SysMenu::sysMenusByPid($header_menu_id)->orderBy('sort')->get();
        $subMenus->map(function($subMenu) {
            $subMenu->subChildMenu = SysMenu::sysMenusByPid($subMenu->id)->orderBy('sort')->get();
            return $subMenu;
        });

        $base = [
            'header_menus' => $header_menus,
            'sidebar_menus' => $subMenus,
        ];
        $view->with('base', $base);
    }
}