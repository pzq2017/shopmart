<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Services\Storage\Local\StorageService;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.article.index');
    }

    public function lists(Request $request)
    {
        $query = Article::with('category')
            ->when($request->title, function ($q) use ($request) {
                return $q->where('title', 'like', '%'.$request->title.'%');
            })
            ->when($request->types, function ($q) use ($request) {
                $catIds = ArticleCategory::categoryByType($request->types)->publishCategory()->pluck('id')->toArray();
                if (!empty($catIds)) {
                    return $q->whereIn('catid', $catIds);
                }
            });
        $count = $query->count();
        $banks = $this->pagination($query, $request);
        return $this->handleSuccess(['total' => $count, 'lists' => $banks]);
    }

    public function create(Request $request)
    {
        $categories = ArticleCategory::publishCategory()->get();
        return view('admin.article.create', compact('categories'));
    }

    public function store(ArticleRequest $request, StorageService $storageService)
    {
        $image_path = $request->image_path;
        $category_type = ArticleCategory::getType($request->catId);
        if ($category_type == ArticleCategory::TYPE_TEXT_AND_PICTURE_LIST) {
            $image_path = $storageService->move('temp/'.$image_path, ['target_dir' => 'article']);
            if (!$image_path) {
                return $this->handleFail('图片保存失败');
            }
        }
        Article::create([
            'catid' => $request->catId,
            'title' => $request->title,
            'text'  => $request->text,
            'desc'  => $request->desc ?? '',
            'author'=> $request->author ?? '',
            'sort'  => $request->sort ?? 0,
            'image_path' => $image_path ?? '',
        ]);
        return $this->handleSuccess();
    }

    public function edit(Article $article)
    {
        $categories = ArticleCategory::publishCategory()->get();
        $category_type = ArticleCategory::getType($article->catid);
        return view('admin.article.edit', compact('article', 'categories', 'category_type'));
    }

    public function update(ArticleRequest $request, Article $article, StorageService $storageService)
    {
        $category_type = ArticleCategory::getType($request->catId);
        if ($category_type == ArticleCategory::TYPE_TEXT_AND_PICTURE_LIST) {
            $image_path = $request->image_path;
            if (!starts_with($image_path, 'article/')) {
                $article->image_path = $storageService->move('temp/'.$image_path, ['target_dir' => 'article']);
                if (!$article->image_path) {
                    return $this->handleFail('图片保存失败');
                }
            }
        }
        $article->catid = $request->catId;
        $article->title = $request->title;
        $article->text = $request->text;
        $article->desc = $request->desc ?? '';
        $article->author = $request->author ?? '';
        $article->sort = $request->sort ?? '';
        $article->save();
        return $this->handleSuccess();
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return $this->handleSuccess();
    }

    public function publish(Request $request, Article $article)
    {
        $article->pub_date = intval($request->publish) > 0 ? Carbon::now() : null;
        $article->save();
        return $this->handleSuccess();
    }
}
