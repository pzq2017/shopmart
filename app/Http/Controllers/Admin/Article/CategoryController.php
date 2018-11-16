<?php

namespace App\Http\Controllers\Admin\Article;

use App\Models\ArticleCategory;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.article.category.index');
    }

    public function lists(Request $request)
    {
        $query = ArticleCategory::when($request->name, function ($query) use ($request) {
            return $query->where('name', 'like', '%'.$request->name.'%');
        });
        $count = $query->count();
        $banks = $this->pagination($query, $request);
        return $this->handleSuccess(['total' => $count, 'lists' => $banks]);
    }

    public function create(Request $request)
    {
        return view('admin.article.category.create');
    }

    public function store(Request $request)
    {
        return $this->handleSuccess();
    }

    public function edit()
    {
        return view('admin.article.category.edit');
    }

    public function update(Request $request)
    {
        return $this->handleSuccess();
    }

    public function destroy()
    {
        return $this->handleSuccess();
    }

    public function updateStatus(Request $request)
    {
        return $this->handleSuccess();
    }
}
