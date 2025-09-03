<?php

namespace App\Models\DTO;

use App\Models\DTO\Interfaces\DTO;
use App\Models\DTO\Traits\DTOToArray;

class PromptDTO implements DTO
{
    use DTOToArray;

    public function __construct(
        private string $persona,
        private string $objective,
        private string $context,
        private string $tone,
        private string $format
    ) {}

    public function getPersona(): string
    {
        return $this->persona;
    }

    public function getObjective(): string
    {
        return $this->objective;
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function getTone(): string
    {
        return $this->tone;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
