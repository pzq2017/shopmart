<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\SysMenu;
use App\Traits\ResponseJsonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use ResponseJsonTrait;

    public function index()
    {
        return view('admin.menu.index');
    }

    public function create(Request $request)
    {
        $parentId = $request->parentId;
        return view('admin.menu.add', compact('parentId'));
    }

    public function store(MenuRequest $request)
    {
        SysMenu::create([
            'parentId' => $request->parentId ?? 0,
            'name' => $request->name,
            'sort' => $request->sort ?? 0,
        ]);

        return $this->handleSuccess();
    }

    public function edit(SysMenu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(MenuRequest $request)
    {
        $menu = SysMenu::findOrFail($request->id);
        $menu->name = $request->name;
        $menu->sort = $request->sort;
        $menu->updated_at = Carbon::now();
        $menu->save();
        return $this->handleSuccess();
    }

    public function destroy(SysMenu $menu)
    {
        $res = $menu->delete();
        return $res ? $this->handleSuccess() : $this->handleFail('删除失败!');
    }

    public function sysMenus(Request $request)
    {
        $menuId = $request->id ?? -1;
        if ($menuId == -1) {
            $datas = [
                'id' => 0,
                'name' => config('app.name'),
                'isParent' => true,
                'open' => true
            ];
        } else {
            $datas = SysMenu::sysMenus($menuId)->orderBy('sort')->get();
            if ($datas->count() > 0) {
                $datas->map(function($data) {
                    $data->isParent = true;
                    return $data;
                });
            }
        }
        return response()->json($datas);
    }
}
