<?php

namespace App\Services;

use App\Models\DTO\UserDTO;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(UserDTO $userData, string $role = 'client')
    {
        $userData->password = Hash::make($userData->password);

        $user = $this->userRepository->create($userData);

        $user->assignRole($role);

        event(new Registered($user));

        return $user;
    }
}
