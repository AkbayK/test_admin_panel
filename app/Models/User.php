<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'author_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeEmployee($query)
    {
        return $query->where('role_id', Role::EMPLOYEE);
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

    public function isAdmin()
    {
        return $this->role_id === Role::ADMIN;
    }

    public function isManager()
    {
        return $this->role_id === Role::MANAGER;
    }

    public function scopeByAuthor($query)
    {
        if (auth()->user()->role_id == Role::MANAGER) {
            $query->where('author_id', auth()->user()->id);
        }
        return $query;
    }
}
