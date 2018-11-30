<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Requests\Admin\MemberRequest;
use App\Models\Member;
use App\Models\SysConfig;
use App\Services\MemberService;
use App\Services\Storage\Local\StorageService;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.member.index');
    }

    public function lists(Request $request)
    {
         $query = Member::when($request->loginAccount, function ($query) use ($request) {
                    return $query->where('loginAccount', 'like', '%'.$request->loginAccount.'%');
                })
                ->when($request->nickname, function ($query) use ($request) {
                    return $query->where('nickname', 'like', '%'.$request->nickname.'%');
                })
                ->when($request->mobile, function ($query) use ($request) {
                    return $query->where('mobile', 'like', '%'.$request->mobile.'%');
                })
                ->when($request->status, function ($query) use ($request) {
                    return $query->where('status', intval($request->status) - 1);
                });
         $count = $query->count();
         $banks = $this->pagination($query, $request);
         return $this->handleSuccess(['total' => $count, 'lists' => $banks]);
    }

    public function create(Request $request)
    {
        return view('admin.member.create');
    }

    public function store(MemberRequest $request, StorageService $storageService)
    {
        $message = $this->verify_account($request->loginAccount);
        if ($message) {
            return $this->handleFail($message);
        }

        $avatar_path = $request->avatar;
        if ($avatar_path) {
            $avatar_path = $storageService->move('temp/'.$avatar_path, ['target_dir' => 'member/avatar']);
            if (!$avatar_path) {
                return $this->handleFail('图片保存失败');
            }
        }
        Member::create([
            'loginAccount'  => $request->loginAccount,
            'loginPwd'      => Hash::make($request->loginPwd),
            'nickname'      => $request->nickname,
            'nickname'      => $request->nickname,
            'avatar'        => $avatar_path,
            'realname'      => $request->realname,
            'sex'           => $request->sex,
            'birthday'      => $request->birthday,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'qq'            => $request->qq,
        ]);
        return $this->handleSuccess();
    }

    public function edit(Member $member)
    {
        return view('admin.member.edit', compact('member'));
    }

    public function update(MemberRequest $request, Member $member, StorageService $storageService)
    {
        $message = $this->verify_account($request->loginAccount);
        if ($message) {
            return $this->handleFail($message);
        }

        $avatar_path = $request->avatar;
        if ($avatar_path && !starts_with($avatar_path, 'member/avatar/')) {
            $member->avatar = $storageService->move('temp/'.$avatar_path, ['target_dir' => 'member/avatar']);
            if (!$member->avatar) {
                return $this->handleFail('图片保存失败');
            }
        }
        $member->loginAccount   = $request->loginAccount;
        $member->nickname       = $request->nickname;
        $member->realname       = $request->realname;
        $member->sex            = $request->sex;
        $member->birthday       = $request->birthday;
        $member->mobile         = $request->mobile;
        $member->email          = $request->email;
        $member->qq             = $request->qq;
        $member->save();
        return $this->handleSuccess();
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return $this->handleSuccess();
    }

    public function activate(Request $request, Member $member)
    {
        $member->status = intval($request->activate) > 0 ? 1 : 0;
        $member->save();
        return $this->handleSuccess();
    }

    private function verify_account($account)
    {
        $error = null;
        if (MemberService::check_register_limit_words($account)) {
            $limitWords = SysConfig::getValue('registerLimitWords');
            $error = '登录账户中不能含有这些特殊字符:'.$limitWords;
        }
        return $error;
    }
}
