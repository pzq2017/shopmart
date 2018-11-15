<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Requests\Admin\AdPositionsRequest;
use App\Models\AdPositions;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdPositionsController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.config.ad_positions.index');
    }

    public function lists(Request $request)
    {
        $query = AdPositions::when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'like', '%'.$request->name.'%');
                });
        $count = $query->count();
        $ad_positions = $this->pagination($query, $request);
        return $this->handleSuccess(['total' => $count(), 'lists' => $ad_positions]);
    }

    public function create(Request $request)
    {
        return view('admin.config.ad_positions.create');
    }

    public function store(AdPositionsRequest $request)
    {
        AdPositions::create([
            'type' => AdPositions::TYPE_PC_PLATFORM,
            'name' => $request->name,
            'width' => $request->width,
            'height' => $request->height,
            'sort' => $request->sort ?? 0,
        ]);
        return $this->handleSuccess();
    }

    public function edit(AdPositions $adPosition)
    {
        return view('admin.config.ad_positions.edit', compact('adPosition'));
    }

    public function update(AdPositionsRequest $request, AdPositions $adPosition)
    {
        $adPosition->name = $request->name;
        $adPosition->width = $request->width;
        $adPosition->height = $request->height;
        $adPosition->sort = $request->sort ?? 0;
        $adPosition->save();
        return $this->handleSuccess();
    }

    public function destroy(AdPositions $adPosition)
    {
        $adPosition->delete();
        return $this->handleSuccess();
    }
}
