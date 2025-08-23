<?php

namespace App\Models\DTO;

use App\Models\Branch;
use App\Models\DTO\Interfaces\DTO;
use App\Models\DTO\Traits\DTOToArray;
use Illuminate\Http\Request;

class BranchDTO implements DTO
{
    use DTOToArray;

    public function __construct(
        private string $name,
        private string $identifier,
        private ?string $cnpj,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->name,
            $request->identifier,
            $request->cnpj
        );
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
