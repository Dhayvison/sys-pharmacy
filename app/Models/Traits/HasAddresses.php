<?php

namespace App\Models\Traits;

use App\Models\Address;

trait HasAddresses
{
    /**
     * Get all of the model's addresses.
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
