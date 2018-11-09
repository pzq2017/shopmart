<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Requests\Admin\BanksRequest;
use App\Models\Banks;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BanksController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.config.banks.index');
    }

    public function lists(Request $request)
    {
        $query = Banks::when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'like', '%'.$request->name.'%');
                });
        $banks = $this->pagination($query, $request);
        return $this->handleSuccess(['total' => $query->count(), 'lists' => $banks]);
    }

    public function create(Request $request)
    {
        return view('admin.config.banks.create');
    }

    public function store(BanksRequest $request)
    {
        Banks::create([
            'name' => $request->name,
            'sort' => $request->sort ?? 0,
        ]);
        return $this->handleSuccess();
    }

    public function edit(Banks $bank)
    {
        return view('admin.config.banks.edit', compact('bank'));
    }

    public function update(BanksRequest $request, Banks $bank)
    {
        $bank->name = $request->name;
        $bank->sort = $request->sort ?? 0;
        $bank->save();
        return $this->handleSuccess();
    }

    public function destroy(Banks $bank)
    {
        $bank->delete();
        return $this->handleSuccess();
    }

    public function update_status(Request $request, Banks $bank)
    {
        $bank->status = $request->publish ? 1 : 0;
        $bank->save();
        return $this->handleSuccess();
    }
}