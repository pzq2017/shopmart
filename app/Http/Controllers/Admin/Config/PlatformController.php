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
        $mailSettingKeys = ['mailSmtp', 'mailPort', 'mailAddress', 'mailSendTitle', 'mailUsername', 'mailPassword'];
        $mailEnvKeys = ['MAIL_HOST', 'MAIL_PORT', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME', 'MAIL_USERNAME', 'MAIL_PASSWORD'];
        $mailEnvKeyValues = [];
        foreach ($fields as $key => $value) {
            SysConfig::updateOrCreate(
                ['code' => $key],
                ['value' => $value]
            );
            $index = array_search($key, $mailSettingKeys);
            if ($index !== false) {
                $mailEnvKeyValues[$mailEnvKeys[$index]] = $value;
                if ($key == 'mailPort') {
                    if ($value == 465 || $value == 994) {
                        $mailEnvKeyValues['MAIL_ENCRYPTION'] = 'ssl';
                    } else {
                        $mailEnvKeyValues['MAIL_ENCRYPTION'] = 'tls';
                    }
                }
            }
        }
        if (!empty($mailEnvKeyValues)) {
            $this->WriteDataToEnv($mailEnvKeyValues);
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

    private function WriteDataToEnv($replaces)
    {
        $items = collect(file(app()->environmentFilePath(), FILE_IGNORE_NEW_LINES));
        $newItems = $items->map(function ($item) use ($replaces) {
            foreach ($replaces as $key => $value) {
                if (str_contains($item, $key)) {
                    return $key. '=' . $value;
                }
            }
            return $item;
        });
        \File::put(app()->environmentFilePath(), implode($newItems->toArray(), "\n"));
    }
}
