<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class BankSekolah extends Model
{
    use HasFactory, SearchableTrait;
    protected $guarded = [];


    protected $searchable = [
        'columns' => [
            'nama_bank' => 10,
        ]
    ];
}
