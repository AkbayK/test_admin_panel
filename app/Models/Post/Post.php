<?php

namespace App\Models\Post;

use App\Models\Category\Category;
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
        if($request->has('name') && !is_null($request->input('name')))
        {
            $name = $request->input('name');
            $query->where('name', 'like', "%$name%");
        }
        return $query;
    }
}
