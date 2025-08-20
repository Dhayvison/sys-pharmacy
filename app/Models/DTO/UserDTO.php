<?php

namespace App\Models\DTO;

use Illuminate\Http\Request;

class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $phone_number,
        public ?string $avatar = null,
        public ?string $google_id = null,
        public ?string $google_token = null,
        public ?string $google_refresh_token = null
    ) {}

    public static function fromArray(array $data): self
    {
        $requiredFields = [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'phone_number' => 'Phone number',
        ];

        foreach ($requiredFields as $field => $label) {
            if (!isset($data[$field]) || !is_string($data[$field]) || trim($data[$field]) === '') {
                throw new \InvalidArgumentException("{$label} is required and must be a non-empty string.");
            }
        }

        return new self(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['phone_number'],
            $data['avatar'] ?? null,
            $data['google_id'] ?? null,
            $data['google_token'] ?? null,
            $data['google_refresh_token'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone_number' => $this->phone_number,
            'avatar' => $this->avatar,
            'google_id' => $this->google_id,
            'google_token' => $this->google_token,
            'google_refresh_token' => $this->google_refresh_token
        ];
    }
}
