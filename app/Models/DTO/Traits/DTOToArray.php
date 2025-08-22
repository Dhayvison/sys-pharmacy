<?php

namespace App\Models\DTO\Traits;

trait DTOToArray
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
