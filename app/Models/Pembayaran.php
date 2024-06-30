<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['tanggal_bayar','tanggal_konfirmasi'];
    protected $with = ['user', 'tagihan'];
    protected $append = ['status_konfirmasi'];


       /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function statusKonfirmasi(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($this->tanggal_konfirmasi == null) ? 'Belum Dikonfirmasi' : 'Sudah Dikonfirmasi'
        );
    }

    /**
     * Get the user that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    /**
     * Get the bankSekolah that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bankSekolah(): BelongsTo
    {
        return $this->belongsTo(BankSekolah::class);
    }

    /**
     * Get the waliBank that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function waliBank(): BelongsTo
    {
        return $this->belongsTo(WaliBank::class);
    }

    /**
     * Get the tagihan that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
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
