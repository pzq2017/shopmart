<?php

namespace App\Http\Controllers\Admin\Config;

use App\Models\SysConfig;
use App\Services\Storage\Local\StorageService;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlatformController extends Controller
{
    use ResponseJsonTrait;

    public function index(Request $request)
    {
        $configs = [];
        SysConfig::all()->map(function ($config) use (&$configs) {
            $configs[$config->code] = $config->value;
        });

        return view('admin.config.platform.index', compact('configs'));
    }

    public function save(Request $request, StorageService $storageService)
    {
        $fields = $this->ImagesMove($request->all(), $storageService);
        foreach ($fields as $key => $value) {
            SysConfig::updateOrCreate(
                ['code' => $key],
                ['value' => $value]
            );
        }
        return $this->handleSuccess();
    }

    private function ImagesMove($fields, $storageService)
    {
        if (isset($fields['platformLogo']) && !starts_with($fields['platformLogo'], 'default/')) {
            $fields['platformLogo'] = $storageService->move('temp/'.$fields['platformLogo'], ['target_dir' => 'default']);
        }
        if (isset($fields['shopLogo']) && !starts_with($fields['shopLogo'], 'default/')) {
            $fields['shopLogo'] = $storageService->move('temp/'.$fields['shopLogo'], ['target_dir' => 'default']);
        }
        if (isset($fields['userLogo']) && !starts_with($fields['userLogo'], 'default/')) {
            $fields['userLogo'] = $storageService->move('temp/'.$fields['userLogo'], ['target_dir' => 'default']);
        }
        if (isset($fields['goodsLogo']) && !starts_with($fields['goodsLogo'], 'default/')) {
            $fields['goodsLogo'] = $storageService->move('temp/'.$fields['goodsLogo'], ['target_dir' => 'default']);
        }
        return $fields;
    }
}
