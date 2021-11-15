<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Models\Category\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $this->items = Category::filter($request);
        return view('categories.index', [
            'items' => $this->items->simplePaginate(10)
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $item = Category::create($validated);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect(route('categories.index'))->with('success', 'Успешно создано');
    }

    public function edit(Category $category)
    {
        return view('categories.create', [
            'item' => $category
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        DB::beginTransaction();
        try {
            $category->update($request->validated());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect(route('categories.index'))->with('success', 'Успешно обновлено');
    }

    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            $category->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e->getMessage(), 400);
        }

        return redirect(route('categories.index'))->with('success', 'Успешно удалено'); 
    }
}
