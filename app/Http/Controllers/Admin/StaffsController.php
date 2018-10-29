<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaffRequest;
use App\Models\Roles;
use App\Models\Staffs;
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
        if ($request->type == 'ajax_get_datas') {
            $request = $this->arrange($request);
            $staffs = Staffs::with('role')
                        ->when($request->loginName, function ($query) use ($request) {
                            return $query->where('loginName', $request->loginName);
                        })
                        ->when($request->staffName, function ($query) use ($request) {
                            return $query->where('staffName', $request->staffName);
                        })
                        ->when($request->staffRoleId, function ($query) use ($request) {
                            return $query->where('staffRoleId', $request->staffRoleId);
                        })
                        ->when($request->workStatus, function ($query) use ($request) {
                            if ($request->workStatus == -1) {
                                $request->workStatus = 0;
                            }
                            return $query->where('workStatus', $request->workStatus);
                        })
                        ->skip($request->offset)
                        ->take($request->pagesize)
                        ->orderBy($request->sortname, $request->sort)
                        ->get();
            return $this->handleSuccess($staffs);
        } else {
            return view('admin.staffs.index');
        }
    }

    public function create()
    {
        $roles = Roles::all();
        return view('admin.staffs.create', compact('roles'));
    }

    public function store(StaffRequest $request)
    {
        $file = $this->move_photo($request->staffPhoto);
        if ($file) {
            if ($this->contains_str($file)) {
                $staffPhoto = $file;
            } else {
                return $this->handleFail($file);
            }
        }
        $staffNo = Staffs::latest()->value('staffNo') ?? 10000;
        $nextStaffNo = $staffNo + 1;
        Staffs::create([
            'loginName' => $request->loginName,
            'password' => Hash::make($request->password),
            'secretKey' => Uuid::uuid4(),
            'staffNo' => $nextStaffNo,
            'staffName' => $request->staffName,
            'staffPhoto' => $staffPhoto ?? '',
            'staffRoleId' => $request->staffRoleId,
            'workStatus' => $request->workStatus ?? 1,
            'staffStatus' => $request->staffStatus ?? 1,
        ]);
        return $this->handleSuccess();
    }

    public function edit(Staffs $staff)
    {
        $roles = Roles::all();
        return view('admin.staffs.edit', compact('roles', 'staff'));
    }

    public function update(StaffRequest $request, Staffs $staff)
    {
        if ($request->password) {
            if (Hash::check($request->password, $staff->password) ==  false && $request->password != $staff->password) {
                $staff->password = Hash::make($request->password);
            }
        }
        $file = $this->move_photo($request->staffPhoto);
        if ($file) {
            if ($this->contains_str($file)) {
                $staff->staffPhoto = $file;
            } else {
                return $this->handleFail($file);
            }
        }
        $staff->loginName = $request->loginName;
        $staff->staffName = $request->staffName;
        $staff->staffRoleId = $request->staffRoleId;
        $staff->workStatus = $request->workStatus;
        $staff->staffStatus = $request->staffStatus;
        $staff->save();
        return $this->handleSuccess();
    }

    public function destroy(Staffs $staff)
    {
        if ($staff->staffRoleId == Staffs::SUPER_USER) {
            return $this->handleFail('不能删除当前用户.');
        }
        $staff->delete();
        return $this->handleSuccess();
    }

    private function move_photo($staffPhoto)
    {
        $move_state = false;
        $result = '';
        if ($staffPhoto && !$this->contains_str($staffPhoto)) {
            if (\Storage::exists('staff') == false) {
                \Storage::makeDirectory('staff');
            }
            $temp_path = 'temp/'.$staffPhoto;
            $new_path = 'staff/'.$staffPhoto;
            if (\Storage::exists($temp_path)) {
                if (\Storage::move($temp_path, $new_path)) {
                    $move_state = true;
                }
            }
            if (!$move_state) {
                $result = '职员照片保存失败.';
            } else {
                $result = $new_path;
            }
        }
        return $result;
    }

    private function contains_str($string)
    {
        return (substr($string, 0, 6) == 'staff/') ? true : false;
    }
}
