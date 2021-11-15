<?php

namespace App\Models\Post;

use App\Models\Category\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'category_id',
        'created_user_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function scopeFilter($query, Request $request)
    {
        if($request->has('id') && !is_null($request->input('id'))) {
            $query->where('id', $request->id);
        }

        if($request->has('name') && !is_null($request->input('name'))) {
            $name = $request->input('name');
            $query->where('name', 'like', "%$name%");
        }

        if ($request->has('category_id') && !is_null($request->input('category_id'))) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('created_user_id') && !is_null($request->input('created_user_id'))) {
            $query->where('created_user_id', $request->input('created_user_id'));
        }

        return $query;
    }

    public function scopeByUser($query)
    {
        $user = auth()->user();

        if ($user->role_id == Role::EMPLOYEE) {
            $query->where('created_user_id', auth()->user()->id);
        }
        else if ($user->role_id == Role::MANAGER) {
            $query->whereHas('author', function ($qEmp) {
                $qEmp->where('author_id', auth()->user()->id);
            })
            ->orWhere('created_user_id', auth()->user()->id);;
        }
        return $query;
    }
}
