<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Requests\Admin\NavsRequest;
use App\Models\Navs;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NavsController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.config.navs.index');
    }

    public function lists(Request $request)
    {
        $query = Navs::when($request->name, function ($query) use ($request) {
                    return $query->where('name', $request->name);
                })
                ->when($request->type, function ($query) use ($request) {
                    $type = $request->type - 1;
                    return $query->where('type', $type);
                });
        $count = $query->count();
        $navs = $this->pagination($query, $request)
                ->map(function ($nav) {
                    $nav_positions = Navs::NAVS_POSITIONS;
                    $nav->typeName = $nav_positions[$nav->type];
                    return $nav;
                });
        return $this->handleSuccess(['total' => $count(), 'lists' => $navs]);
    }

    public function create(Request $request)
    {
        return view('admin.config.navs.create');
    }

    public function store(NavsRequest $request)
    {
        Navs::create([
            'type' => $request->type,
            'name' => $request->name,
            'url' => $request->url,
            'isShow' => $request->isShow,
            'isTarget' => $request->isTarget,
            'sort' => $request->sort,
        ]);
        return $this->handleSuccess();
    }

    public function edit(Navs $nav)
    {
        return view('admin.config.navs.edit', compact('nav'));
    }

    public function update(NavsRequest $request, Navs $nav)
    {
        $nav->name = $request->name;
        $nav->url = $request->url;
        $nav->type = $request->type;
        $nav->isTarget = $request->isTarget;
        $nav->isShow = $request->isShow;
        $nav->sort = $request->sort;
        $nav->save();
        return $this->handleSuccess();
    }

    public function setShow(Request $request, Navs $nav)
    {
        $nav->isShow = intval($request->show) > 0 ? 1 : 0;
        $nav->save();
        return $this->handleSuccess();
    }
}
