<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Requests\Admin\FriendLinksRequest;
use App\Models\FriendLinks;
use App\Services\Storage\Local\StorageService;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FriendLinksController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.config.friend_links.index');
    }

    public function lists(Request $request)
    {
        $query = FriendLinks::when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'like', '%'.$request->name.'%');
                });
        $count = $query->count();
        $ads = $this->pagination($query, $request);
        return $this->handleSuccess(['total' => $count, 'lists' => $ads]);
    }

    public function create(Request $request)
    {
        return view('admin.config.friend_links.create');
    }

    public function store(FriendLinksRequest $request, StorageService $storageService)
    {
        $image_path = $storageService->move('temp/'.$request->image_path, ['target_dir' => 'friend_links']);
        if (!$image_path) {
            return $this->handleFail('图片保存失败');
        }
        FriendLinks::create([
            'name' => $request->name,
            'ico' => $image_path,
            'link' => $request->link ?? '',
            'sort' => $request->sort ?? 0,
        ]);
        return $this->handleSuccess();
    }

    public function edit(FriendLinks $friendLink)
    {
        return view('admin.config.friend_links.edit', compact('friendLink'));
    }

    public function update(FriendLinksRequest $request, FriendLinks $friendLink, StorageService $storageService)
    {
        $image_path = $request->image_path;
        if (!starts_with($image_path, 'friend_links/')) {
            $friendLink->ico = $storageService->move('temp/'.$image_path, ['target_dir' => 'friend_links']);
            if (!$friendLink->ico) {
                return $this->handleFail('图片上传失败');
            }
        }
        $friendLink->name = $request->name;
        $friendLink->link = $request->link ?? '';
        $friendLink->sort = $request->sort ?? 0;
        $friendLink->save();
        return $this->handleSuccess();
    }

    public function destroy(FriendLinks $friendLink)
    {
        $friendLink->delete();
        return $this->handleSuccess();
    }

    public function isShow(Request $request, FriendLinks $friendLink)
    {
        $friendLink->isShow = intval($request->isShow) > 0 ? 1 : 0;
        $friendLink->save();
        return $this->handleSuccess();
    }
}
