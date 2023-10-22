<?php

namespace App\Traits\Acessor;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ConverDateToIndonesia
{
    /**
     * Get the user's first name.
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s'),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s'),
        );
    }

}
