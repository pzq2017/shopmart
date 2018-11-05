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
        $startDate = null;
        $endDate = null;
        if (!empty($request->dateRange)) {
            $dateArr = explode('~', $request->dateRange);
            $startDate = $dateArr[0];
            $endDate = $dateArr[1];
        }
        $logs = LogStaffLogin::with('staff')
            ->whereHas('staff', function ($query) use ($request) {
                if ($request->loginName) {
                    return $query->where('loginName', $request->loginName);
                }
            })
            ->when($startDate, function ($query) use ($startDate) {
                $startDate_time = Carbon::parse($startDate)->timestamp;
                return $query->whereRaw("UNIX_TIMESTAMP(created_at) >= $startDate_time");
            })
            ->when($endDate, function ($query) use ($endDate) {
                $endDate_time = Carbon::parse($endDate)->timestamp;
                return $query->whereRaw("UNIX_TIMESTAMP(created_at) < $endDate_time");
            })
            ->skip($request->offset)
            ->take($request->limit)
            ->orderBy($request->sortname, $request->sort)
            ->get();
        return $this->handleSuccess($logs);
    }
}
