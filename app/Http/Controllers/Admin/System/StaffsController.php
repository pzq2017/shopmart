<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaffRequest;
use App\Models\Roles;
use App\Models\Staffs;
use App\Services\Storage\Local\StorageService;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class StaffsController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        $roles = Roles::all();
        return view('admin.system.staffs.index', compact('roles'));
    }

    public function lists(Request $request)
    {
        $query = Staffs::with('role')
            ->when($request->loginName, function ($query) use ($request) {
                return $query->where('loginName', $request->loginName);
            })
            ->when($request->staffRoleId, function ($query) use ($request) {
                return $query->where('staffRoleId', $request->staffRoleId);
            });
        $count = $query->count();
        $staffs = $this->pagination($query, $request);
        return $this->handleSuccess(['total' => $count, 'lists' => $staffs]);
    }

    public function create()
    {
        $roles = Roles::all();
        return view('admin.system.staffs.create', compact('roles'));
    }

    public function store(StaffRequest $request, StorageService $storageService)
    {
        $staffPhoto = $request->staffPhoto;
        if ($staffPhoto && !starts_with($staffPhoto, 'staff/')) {
            $staffPhoto = $storageService->move('temp/'.$staffPhoto, ['target_dir' => 'staff']);
        }
        Staffs::create([
            'loginName' => $request->loginName,
            'password' => Hash::make($request->password),
            'secretKey' => Uuid::uuid4(),
            'staffName' => $request->staffName,
            'staffPhone' => $request->staffPhone,
            'staffEmail' => $request->staffEmail,
            'staffPhoto' => $staffPhoto,
            'staffRoleId' => $request->staffRoleId,
            'status' => $request->status ?? Staffs::STATUS_DISABLED,
        ]);
        return $this->handleSuccess();
    }

    public function edit(Staffs $staff)
    {
        $roles = Roles::all();
        return view('admin.system.staffs.edit', compact('roles', 'staff'));
    }

    public function update(StaffRequest $request, Staffs $staff, StorageService $storageService)
    {
        if ($request->password) {
            if (Hash::check($request->password, $staff->password) ==  false && $request->password != $staff->password) {
                $staff->password = Hash::make($request->password);
            }
        }

        $staffPhoto = $request->staffPhoto;
        if ($staffPhoto && !starts_with($staffPhoto, 'staff/')) {
            $staff->staffPhoto = $storageService->move('temp/'.$staffPhoto, ['target_dir' => 'staff']);
        }

        $staff->loginName = $request->loginName;
        $staff->staffPhone = $request->staffPhone;
        $staff->staffEmail = $request->staffEmail;
        $staff->staffRoleId = $request->staffRoleId;
        $staff->status = $request->status;
        $staff->save();
        return $this->handleSuccess();
    }

    public function destroy(Staffs $staff)
    {
        if ($staff->staffRoleId == Staffs::SUPER_USER) {
            return $this->handleFail('不能删除超管账户.');
        }
        $staff->delete();
        return $this->handleSuccess();
    }

    public function setEnabled(Request $request, Staffs $staff)
    {
        $staff->status = intval($request->enabled) > 0 ? 1 : 0;
        $staff->save();
        return $this->handleSuccess();
    }
}
