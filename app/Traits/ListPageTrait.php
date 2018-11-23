<?php

namespace App\Traits;

trait ListPageTrait
{
    private function pagination($query, $request)
    {
        $curPage = $request->page ?? 1;
        $request->limit = $request->limit ?? 25;
        $request->offset = ($curPage - 1) * $request->limit;
        $request->order = $request->order ?? 'desc';
        $request->field = $request->field ?? 'updated_at';

        return $query->skip($request->offset)
            ->take($request->limit)
            ->orderBy($request->field, $request->order)
            ->get();
    }
}