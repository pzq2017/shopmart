<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdPwdRequest;
use App\Models\SysMenu;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    use ResponseJsonTrait;

    public function index()
    {
        return view('admin.index');
    }

    public function clearCache()
    {
        \Artisan::call('qk:clear');
        return $this->handleSuccess();
    }

    public function updatPwd(UpdPwdRequest $request)
    {
        $user = admin_auth();
        $res = \Hash::check($request->oldPwd, $user->password);
        if (!$res) {
            return $this->handleFail('原始密码输入错误');
        } else {
            $user->password = \Hash::make($request->newPwd);
            $user->setRememberToken(Str::random(60));
            $user->save();
            Auth::guard('admin')->login($user);
            return $this->handleSuccess();
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return $this->handleSuccess();
    }
}
