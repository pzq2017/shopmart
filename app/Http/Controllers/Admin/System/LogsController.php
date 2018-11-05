<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\LogStaffLogin;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.logs.index');
    }

    public function lists(Request $request)
    {
        $request = $this->arrange($request);
        $logs = LogStaffLogin::with(['staff' => function ($query) use ($request) {
            if ($request->loginName) {
                return $query->where('loginName', $request->loginName);
            }
        }])
            ->whereHas('staff', function ($query) use ($request) {
                if ($request->loginName) {
                    return $query->where('loginName', $request->loginName);
                }
            })
            ->when($request->startDate, function ($query) use ($request) {
                $startDate_time = Carbon::parse($request->startDate)->timestamp;
                return $query->whereRaw("UNIX_TIMESTAMP(created_at) >= $startDate_time");
            })
            ->when($request->endDate, function ($query) use ($request) {
                $endDate_time = Carbon::parse($request->endDate)->timestamp + 24 * 3600;
                return $query->whereRaw("UNIX_TIMESTAMP(created_at) < $endDate_time");
            })
            ->skip($request->offset)
            ->take($request->limit)
            ->orderBy($request->sortname, $request->sort)
            ->get();
        return $this->handleSuccess($logs);
    }
}
