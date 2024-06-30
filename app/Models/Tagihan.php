<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tagihan extends Model
{
    use HasFactory;
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $searchable = [
        'columns' => [
            'siswas.nama' => 10,
            'siswas.nisn' => 9,
        ],
        'joins' => [
            'siswas' => ['siswas.id', 'tagihans.siswa_id'],
        ]
    ];

    protected $guarded = [];
    protected $dates = ['tanggal_tagihan', 'tanggal_jatuh_tempo'];
    protected $with = ['user', 'siswa', 'tagihanDetails'];
    protected $append = ['total_tagihan'];


    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function totalTagihan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->tagihanDetails()->sum('jumlah_biaya'),
        );
    }

    /**
     * Get all of the pembayaran for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function getStatusTagihanWali()
    {
        if ($this->status ==  'baru') {
            return 'belum dibayar';
        }

        if ($this->status ==  'lunas') {
            return 'sudah dibayar';
        }

        return $this->status;
    }

    public function scopeWaliSiswa($q)
    {
        return $q->whereIn('siswa_id', Auth::user()->getAllSiswaId());
    }

    /**
     * Get the user that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the siswa that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get all of the tagihanDetails for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihanDetails(): HasMany
    {
        return $this->hasMany(tagihanDetail::class);
    }


    protected static function booted()
    {
        // creating -> sebelum dibuat
        // created -> setelah dibuat
        Static::creating(function($tagihan){
            $tagihan->user_id = auth()->user()->id;
        });

        // updating -> sebelum dibuat
        // updated -> setelah dibuat
        Static::updating(function($tagihan){
            $tagihan->user_id = auth()->user()->id;
        });
    }
}
