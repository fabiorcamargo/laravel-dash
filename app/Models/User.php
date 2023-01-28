<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'username',
        'email',
        'email2',
        'name',
        'lastname',
        'password',
        'cellphone',
        'cellphone2',
        'city',
        'city2',
        'uf',
        'uf2',
        'payment',
        'role',
        'ouro',
        'secretary',
        'document',
        'seller',
        'courses',
        'active',
        'image',
        'codesale',
        'observation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUsers(string|null $search = null)
    {
        $users = $this->where(function ($query) use ($search) {
            if ($search) {
                $query->where('username', $search);
                $query->orWhere('name', 'LIKE', "%{$search}%");
                $query->orWhere('lastname', 'LIKE', "%{$search}%");
                $query->orWhere('email', 'LIKE', "%{$search}%");
                $query->orWhere('city', 'LIKE', "%{$search}%");
            }
        })
        ->paginate();

        return $users;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function cademis()
    {
        return $this->hasMany(Cademi::class);
    }
    public function cademicourses()
    {
        return $this->hasMany(CademiCourse::class);
    }
    public function avatar()
    {
        return $this->hasMany(Avatar::class);
    }
    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
