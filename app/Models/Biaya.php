<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nicolaslopezj\Searchable\SearchableTrait;

class Biaya extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $searchable = [
        'columns' => [
            'nama' => 10,
        ]
    ];

    protected $guarded = [];
    protected $append = ['nama_biaya_full', 'total_tagihan'];

    /**
     * Get all of the children for the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Biaya::class, 'parent_id');
    }

    /**
     * Get the user that owns the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the siswa for the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function namaBiayaFull(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->nama . ' - ' . $this->formatRupiah('jumlah'),
        );
    }

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function totalTagihan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->children()->sum('jumlah'),
        );
    }

    protected static function booted()
    {
        // creating -> sebelum dibuat
        // created -> setelah dibuat
        Static::creating(function($biaya){
            $biaya->user_id = auth()->user()->id;
        });

        // updating -> sebelum dibuat
        // updated -> setelah dibuat
        Static::updating(function($biaya){
            $biaya->user_id = auth()->user()->id;
        });
    }

}
