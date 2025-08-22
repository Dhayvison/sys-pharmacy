<?php

namespace App\Models\DTO;

use App\Models\DTO\Interfaces\DTO;
use App\Models\DTO\Traits\DTOToArray;

class UserDTO implements DTO
{
    use DTOToArray;

    public function __construct(
        private string $name,
        private string $email,
        private string $password,
        private ?string $avatar = null,
        private ?string $google_id = null,
        private ?string $google_token = null,
        private ?string $google_refresh_token = null
    ) {}

    public function getPassword(): string
    {
        return $this->password;
    }

    public function withPassword(string $password): self
    {
        return new self(
            $this->name,
            $this->email,
            $password,
            $this->avatar,
            $this->google_id,
            $this->google_token,
            $this->google_refresh_token
        );
    }
}
