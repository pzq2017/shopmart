<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FrontMenuRequest;
use App\Models\FrontMenu;
use App\Traits\ResponseJsonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeMenuController extends Controller
{

	use ResponseJsonTrait;

    public function index(Request $request)
    {
    	if ($request->type == 'ajax_get_datas') {
    		$parentId = intval($request->id);
    		$type = intval($request->type);
    		$types = FrontMenu::menuTypes();
    		$frontMenus = FrontMenu::childMenu($parentId)
    						->typeOfMenu($type)
    						->orderBy('sort', 'asc')
    						->get()
    						->map(function ($frontMenu) use ($types) {
				    			$frontMenu->typeName = $types[$frontMenu->type];
				    			return $frontMenu;
				    		});
    		return $this->handleSuccess($frontMenus);
    	} else {
    		$types = FrontMenu::menuTypes();
    		return view('admin.homemenu.index', compact('types'));
    	}
    }

    public function create(Request $request)
    {
    	$parentId = $request->parentId;
    	$types = FrontMenu::menuTypes();
    	return view('admin.homemenu.create', compact('types', 'parentId'));
    }

    public function store(FrontMenuRequest $request)
    {
    	FrontMenu::create([
    		'parentId' => $request->parentId ?? 0,
    		'name' => $request->name,
    		'url' => $request->url,
    		'otherUrl' => $request->otherUrl,
    		'type' => $request->type,
    		'isShow' => $request->isShow ?? 0,
    		'sort' => $request->sort ?? 0
    	]);

    	return $this->handleSuccess();
    }

    public function edit(FrontMenu $homemenu)
    {
    	$types = FrontMenu::menuTypes();
    	return view('admin.homemenu.edit', compact('types', 'homemenu'));
    }

    public function update(FrontMenuRequest $request)
    {
    	try {
    		$frontMenu = FrontMenu::findOrFail($request->id);
    		$frontMenu->name = $request->name;
    		$frontMenu->url = $request->url;
    		$frontMenu->otherUrl = $request->otherUrl;
    		$frontMenu->type = $request->type;
    		$frontMenu->isShow =$request->isShow ?? 0;
    		$frontMenu->sort  = $request->sort ?? 0;
    		$frontMenu->updated_at = Carbon::now();
    		$frontMenu->save();
    		return $this->handleSuccess();
    	} catch (\Exception $e) {
    		return $this->handleFail('更新失败.', 404);
    	}
    }

    public function destroy($id)
    {
    	DB::beginTransaction();
    	try {
    		$frontMenu = FrontMenu::findOrFail($id);
    		$this->delete_child_menus($frontMenu);
    		$frontMenu->delete();
    		DB::commit();
    		return $this->handleSuccess();
    	} catch (\Exception $e) {
    		DB::rollback();
    		return $this->handleFail('删除失败.', 404);
    	}
    }

    private function delete_child_menus($menu)
    {
    	FrontMenu::childMenu($menu->id)->get()->map(function($childMenu) {
    		$childMenu->delete();
    		$this->delete_child_menus($childMenu);
    	});
    }
}
