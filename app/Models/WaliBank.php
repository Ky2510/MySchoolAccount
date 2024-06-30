<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaliBank extends Model
{
    use HasFactory;

    protected $append = ['nama_bank_full'];
    protected $guarded = [];

      /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function namaBankFull(): Attribute
    {
        // Bank BRI - An. Budi (1000000-00000-00000)
        return Attribute::make(
            get: fn ($value) => $this->nama_bank . ' - An.' . $this->nama_rekening . ' (' . $this->no_rekening . ') ',
        );
    }
}
