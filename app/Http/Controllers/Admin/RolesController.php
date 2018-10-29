<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolesRequest;
use App\Models\Roles;
use App\Models\SysMenu;
use App\Models\SysMenuPrivileges;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        if ($request->type == 'ajax_get_datas') {
            $request = $this->arrange($request);
            $roles = Roles::skip($request->offset)
                        ->take($request->pagesize)
                        ->orderBy($request->sortname, $request->sort)
                        ->get();
            return $this->handleSuccess($roles);
        } else {
            return view('admin.roles.index');
        }
    }

    public function create()
    {
        $sysMenus = json_encode($this->menuPrivileges(0));
        return view('admin.roles.create', compact('sysMenus'));
    }

    public function store(RolesRequest $request)
    {
        Roles::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'privileges' => $request->privileges
        ]);

        return $this->handleSuccess();
    }

    public function edit(Roles $role)
    {
        $privileges = array();
        if ($role->privileges) {
            $privileges = explode(',', $role->privileges);
        }
        $sysMenus = json_encode($this->menuPrivileges(0, $privileges));
        return view('admin.roles.edit', compact('sysMenus', 'role'));
    }

    public function update(RolesRequest $request, Roles $role)
    {
        $role->name = $request->name;
        $role->desc = $request->desc;
        $role->privileges = $request->privileges;
        $role->updated_at = Carbon::now();
        $role->save();
        return $this->handleSuccess();
    }

    public function destroy(Roles $role)
    {
        $role->delete();
        return $this->handleSuccess();
    }

    private function menuPrivileges($menuId, $selectedPrivileges=array())
    {
        $sysMenus = SysMenu::leftJoin('sys_menus_privileges', 'sys_menus.id', '=', 'sys_menus_privileges.menuId')
                        ->sysMenus($menuId)
                        ->where('sys_menus_privileges.isMenu', 1)
                        ->select('sys_menus.id', 'sys_menus.name', 'sys_menus_privileges.code')
                        ->orderBy('sort')
                        ->get()
                        ->map(function ($sysMenu) use ($selectedPrivileges) {
                            $children = $this->menuPrivileges($sysMenu->id, $selectedPrivileges);
                            if ($children) {
                                $sysMenu->open = true;
                                $sysMenu->privileges()
                                        ->select('id', 'name', 'code')
                                        ->get()
                                        ->map(function ($privilege) use (&$children, $selectedPrivileges) {
                                            if (in_array($privilege->code, $selectedPrivileges)) {
                                                $privilege->checked = true;
                                            }
                                            $children->prepend($privilege);
                                        });
                                $sysMenu->children = $children;
                            } else {
                                $sysMenu->children = null;
                            }
                            if (in_array($sysMenu->code, $selectedPrivileges)) {
                                $sysMenu->checked = true;
                            }
                            return $sysMenu;
                        });
        return $sysMenus;
    }
}
