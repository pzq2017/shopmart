<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Requests\Admin\ArticleCategoryRequest;
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

    public function store(ArticleCategoryRequest $request)
    {
        ArticleCategory::create([
            'pid' => 0,
            'type' => $request->type,
            'name' => $request->name,
            'sort' => $request->sort ?? 0
        ]);
        return $this->handleSuccess();
    }

    public function edit(ArticleCategory $category)
    {
        return view('admin.article.category.edit', compact('category'));
    }

    public function update(ArticleCategoryRequest $request, ArticleCategory $category)
    {
        $category->type = $request->type;
        $category->name = $request->name;
        $category->sort = $request->sort ?? 0;
        $category->save();
        return $this->handleSuccess();
    }

    public function destroy(ArticleCategory $category)
    {
        $category->delete();
        return $this->handleSuccess();
    }

    public function publish(Request $request, ArticleCategory $category)
    {
        $category->status = intval($request->publish) > 0 ? 1 : 0;
        $category->save();
        return $this->handleSuccess();
    }
}
