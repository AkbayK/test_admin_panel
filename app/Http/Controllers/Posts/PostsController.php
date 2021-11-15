<?php

namespace App\Http\Controllers\Posts;

use App\Actions\PostSaveAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Category\Category;
use App\Models\Employee;
use App\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Post::class);

        $this->items = Post::byUser()->filter($request);
        return view('posts.index', [
            'items' => $this->items->simplePaginate(10),
            'categories' => Category::get(),
            'employees' => Employee::get(),
            'request_ar' => $request,
        ]);
    }

    public function create()
    {
        return view('posts.create', [
            'categories' => Category::get(),
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validated();
        $validated['created_user_id'] = auth()->user()->id;
        $action = new PostSaveAction(new Post(), $validated);

        DB::beginTransaction();
        try {
            $item = $action->run();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect(route('posts.index'))->with('success', 'Успешно создано');
    }

    public function edit(Post $post)
    {
        return view('posts.create', [
            'item' => $post,
            'categories' => Category::get(),
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $action = new PostSaveAction($post, $request->validated());

        DB::beginTransaction();
        try {
            $item = $action->run();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect(route('posts.index'))->with('success', 'Успешно обновлено');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        DB::beginTransaction();
        try {
            $post->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e->getMessage(), 400);
        }

        return redirect(route('posts.index'))->with('success', 'Успешно удалено'); 
    }
}
