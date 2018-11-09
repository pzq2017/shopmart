<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Requests\Admin\AreaRequest;
use App\Models\Area;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        $pid = $request->pid ?? 0;
        if ($pid > 0) {
            $prev_pid = Area::where('id', $pid)->value('pid');
        } else {
            $prev_pid = $pid;
        }
        return view('admin.config.areas.index', compact('pid', 'prev_pid'));
    }

    public function lists(Request $request)
    {
        $pid = intval($request->pid) ?? 0;
        $type = Area::getType($pid);
        $query = Area::where('pid', $pid)
                ->where('type', $type)
                ->when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'like', '%'.$request->name.'%');
                });
        $areas = $this->pagination($query, $request);
        return $this->handleSuccess(['total' => $query->count(), 'lists' => $areas]);
    }

    public function create(Request $request)
    {
        $pid = intval($request->pid) ?? 0;
        $type = Area::getType($pid);
        return view('admin.config.areas.create', compact('pid', 'type'));
    }

    public function store(AreaRequest $request)
    {
        Area::create([
            'pid'   => $request->pid ?? 0,
            'type' => $request->type ?? 0,
            'name' => $request->name,
            'first_letter' => $request->first_letter,
            'isShow' => $request->isShow,
            'sort'  => $request->sort ?? 0
        ]);
        return $this->handleSuccess();
    }

    public function edit(Area $area)
    {
        return view('admin.config.areas.edit', compact('area'));
    }

    public function update(AreaRequest $request, Area $area)
    {
        $area->name = $request->name;
        $area->first_letter = $request->first_letter;
        $area->isShow = $request->isShow;
        $area->sort = $request->sort ?? 0;
        $area->save();
        return $this->handleSuccess();
    }

    public function destroy(Area $area)
    {
        $area->delete();
        return $this->handleSuccess();
    }
}