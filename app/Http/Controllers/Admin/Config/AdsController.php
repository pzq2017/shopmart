<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Requests\Admin\AdsRequest;
use App\Models\AdPositions;
use App\Models\Ads;
use App\Services\Storage\Local\StorageService;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdsController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        $ad_positions = AdPositions::orderBySort()->get();
        return view('admin.config.ads.index', compact('ad_positions'));
    }

    public function lists(Request $request)
    {
        $query = Ads::with('ad_positions')
                ->when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'like', '%'.$request->name.'%');
                });
        $ads = $this->pagination($query, $request);
        return $this->handleSuccess(['total' => $query->count(), 'lists' => $ads]);
    }

    public function create(Request $request)
    {
        $ad_positions = AdPositions::orderBySort()->get();
        return view('admin.config.ads.create', compact('ad_positions'));
    }

    public function store(AdsRequest $request, StorageService $storageService)
    {
        $image_path = $request->image_path;
        if ($image_path && !starts_with($image_path, 'ad/')) {
            $image_path = $storageService->move('temp/'.$image_path, ['target_dir' => 'ad']);
        }
        Ads::create([
            'type' => AdPositions::TYPE_PC_PLATFORM,
            'posid' => $request->posid,
            'name' => $request->name,
            'image_path' => $image_path,
            'url' => $request->url ?? '',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'sort' => $request->sort ?? 0,
        ]);
        return $this->handleSuccess();
    }

    public function edit(Ads $ad)
    {
        $ad_position_size = '';
        $ad_positions = AdPositions::orderBySort()->get();
        $ad_positions->map(function ($ad_position) use ($ad, &$ad_position_size) {
            if ($ad_position->id ==  $ad->posid) {
                $ad_position_size = $ad_position->width . '*' . $ad_position->height;
            }
        });
        return view('admin.config.ads.edit', compact('ad_positions', 'ad', 'ad_position_size'));
    }

    public function update(AdsRequest $request, Ads $ad, StorageService $storageService)
    {
        $image_path = $request->image_path;
        if ($image_path && !starts_with($image_path, 'ad/')) {
            $image_path = $storageService->move('temp/'.$image_path, ['target_dir' => 'ad']);
        }
        $ad->posid = $request->posid;
        $ad->name = $request->name;
        $ad->url = $request->url ?? '';
        $ad->image_path = $image_path;
        $ad->start_date = $request->start_date;
        $ad->end_date = $request->end_date;
        $ad->sort = $request->sort ?? 0;
        $ad->save();
        return $this->handleSuccess();
    }

    public function destroy(Ads $ad)
    {
        $ad->delete();
        return $this->handleSuccess();
    }

    public function update_publish_date(Request $request, Ads $ad)
    {
        $ad->publish_date = $request->publish ? Carbon::now() : null;
        $ad->save();
        return $this->handleSuccess();
    }
}
