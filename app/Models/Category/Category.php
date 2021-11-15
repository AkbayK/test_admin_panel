<?php

namespace App\Models\Category;

use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
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
