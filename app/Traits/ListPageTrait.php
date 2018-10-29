<?php

namespace App\Traits;

trait ListPageTrait
{

    private function arrange($request)
    {
    	$curPage = $request->page ?? 1;
        $request->pagesize = $request->pagesize ?? 25;
        $request->offset = ($curPage - 1) * $request->pagesize;
        $request->sort = $request->sortorder ?? 'desc';
        $request->sortname = $request->sortname ?? 'updated_at';
 		return $request;
    }
}