<?php

namespace App\Models\DTO;

use Illuminate\Http\Request;

readonly class UserDTO
{
    public function __construct(
        private string $name,
        private string $email,
        private string $password,
        private string $phone_number,
        private ?string $avatar = null,
        private ?string $google_id = null,
        private ?string $google_token = null,
        private ?string $google_refresh_token = null
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
            $request->input('phone_number'),
            $request->input('avatar'),
            $request->input('google_id'),
            $request->input('google_token'),
            $request->input('google_refresh_token')
        );
    }

    public static function fromArray(array $data): self
    {
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
            $this->phone_number,
            $this->avatar,
            $this->google_id,
            $this->google_token,
            $this->google_refresh_token
        );
    }
}
