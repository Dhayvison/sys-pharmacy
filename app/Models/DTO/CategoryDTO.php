<?php

namespace App\Models\DTO;

use App\Models\DTO\Interfaces\DTO;
use App\Models\DTO\Traits\DTOToArray;

class CategoryDTO implements DTO
{
    use DTOToArray;

    public function __construct(
        private string $name,
        private ?string $description
    ) {}
}
