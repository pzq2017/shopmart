<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Requests\Admin\MemberGradeRequest;
use App\Models\MemberGrade;
use App\Services\Storage\Local\StorageService;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.member.grade.index');
    }

    public function lists(Request $request)
    {
        $query = MemberGrade::when($request->name, function ($query) use ($request) {
            return $query->where('name', 'like', '%'.$request->name.'%');
        });
        $count = $query->count();
        $banks = $this->pagination($query, $request);
        return $this->handleSuccess(['total' => $count, 'lists' => $banks]);
    }

    public function create(Request $request)
    {
        return view('admin.member.grade.create');
    }

    public function store(MemberGradeRequest $request, StorageService $storageService)
    {
        $icon_path = $storageService->move('temp/'.$request->icon, ['target_dir' => 'member/grade']);
        if (!$icon_path) {
            return $this->handleFail('图片保存失败');
        }

        MemberGrade::create([
            'name'  => $request->name,
            'icon'  => $icon_path,
            'min_score' => $request->min_score,
            'max_score' => $request->max_score
        ]);
        return $this->handleSuccess();
    }

    public function edit(MemberGrade $grade)
    {
        return view('admin.member.grade.edit', compact('grade'));
    }

    public function update(MemberGradeRequest $request, MemberGrade $grade, StorageService $storageService)
    {
        $icon_path = $request->icon;
        if ($icon_path && !starts_with($icon_path, 'member/grade/')) {
            $grade->icon = $storageService->move('temp/'.$icon_path, ['target_dir' => 'member/grade']);
            if (!$grade->icon) {
                return $this->handleFail('图片保存失败');
            }
        }
        $grade->name = $request->name;
        $grade->min_score = $request->min_score;
        $grade->max_score = $request->max_score;
        $grade->save();
        return $this->handleSuccess();
    }
}
