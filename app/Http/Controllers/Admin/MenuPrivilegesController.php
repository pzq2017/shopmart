<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuPrivilegesRequest;
use App\Models\SysMenu;
use App\Models\SysMenuPrivileges;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;

class MenuPrivilegesController extends Controller
{

	use ResponseJsonTrait;

    public function index(Request $request)
    {
    	$menuId = intval($request->menuId);
        try {
            $menu = SysMenu::with('privileges')->findOrFail($menuId);
            return $this->handleSuccess($menu->privileges);
        } catch (\Exception $e) {
            return $this->handleFail('访问错误', 404);
        }
    }

    public function create(Request $request)
    {
        $menuId = $request->menuId;
        return view('admin.menu.privilege.add', compact('menuId'));
    }

    public function store(MenuPrivilegesRequest $request)
    {
    	$privileges = SysMenuPrivileges::create([
    		'name' => $request->name,
    		'code' => $request->code,
    		'menuId' => $request->menuId,
    		'isMenu' => $request->isMenu,
    		'url' => $request->url,
    		'otherUrl' => $request->otherUrl,
    	]);

    	if ($privileges && $privileges->id > 0) {
    		return $this->handleSuccess();
    	} else {
    		return $this->handleFail('保存失败');
    	}
    }

    public function edit(SysMenuPrivileges $privilege)
    {
    	return view('admin.menu.privilege.edit', compact('privilege'));
    }

    public function update(MenuPrivilegesRequest $request, SysMenuPrivileges $privilege)
    {
        $privilege->name = $request->name;
        $privilege->code = $request->code;
        $privilege->isMenu = $request->isMenu;
        $privilege->url = $request->url;
        $privilege->otherUrl = $request->otherUrl;
        $privilege->save();
        return $this->handleSuccess();
    }

    public function destroy(SysMenuPrivileges $privilege)
    {
        $res = $privilege->delete();
        return $res ? $this->handleSuccess() : $this->handleFail('删除失败!');
    }
}
