<?php

namespace App\Models;

use Spatie\ModelStatus\HasStatuses;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    use SearchableTrait;
    use HasStatuses;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'nama' => 10,
            'nisn' => 9,
        ]
    ];

    /**
     * Get the user that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the biaya for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function biaya(): belongsTo
    {
        return $this->belongsTo(Biaya::class);
    }
    /**
     * Get the wali that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    /**
     * Get all of the tagihan for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }

    protected static function booted()
    {
        // sebelum data dibuat
        Static::creating(function($siswa){
            $siswa->user_id = auth()->user()->id;
        });

        // sesudah data dibuat
        Static::created(function($siswa){
            $siswa->setStatus('aktif');
        });

        Static::updating(function($siswa){
            $siswa->user_id = auth()->user()->id;
        });
    }
}
