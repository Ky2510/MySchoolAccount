<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'email' => 9,
        ]
    ];

    protected $fillable = [
        'name',
        'email',
        'akses',
        'nohp',
        'nohp_verified_at',
        'password',
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

    public function scopeWali($q)
    {
        return $q->where('akses', 'wali');
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'wali_id', 'id');
    }

    public function getAllSiswaId() : array
    {
        return $this->siswa->pluck('id')->toArray();
    }
}
