<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogOperate;
use App\Models\LogStaffLogin;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController extends Controller
{
	use ResponseJsonTrait;
	use ListPageTrait;

    public function staffsLogin(Request $request)
    {
    	if ($request->type == 'ajax_get_datas') {
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
    					->take($request->pagesize)
    					->orderBy($request->sortname, $request->sort)
    					->get();
    		return $this->handleSuccess($logs);
    	} else {
    		return view('admin.logs.staffs.login');
    	}
    }

	public function staffsOperate(Request $request)
	{
		if ($request->type == 'ajax_get_datas') {
			$request = $this->arrange($request);
			$logs = LogOperate::with(['staff' => function ($query) use ($request) {
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
				->take($request->pagesize)
				->orderBy($request->sortname, $request->sort)
				->get();
			return $this->handleSuccess($logs);
		} else {
			return view('admin.logs.staffs.operate');
		}
	}
}
