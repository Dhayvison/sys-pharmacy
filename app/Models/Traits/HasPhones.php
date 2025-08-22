<?php

namespace App\Models\Traits;

use App\Models\Phone;

trait HasPhones
{
    /**
     * Get the phones associated with the model.
     */
    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }
}
