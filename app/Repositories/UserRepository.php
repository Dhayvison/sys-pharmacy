<?php

namespace App\Repositories;

use App\Models\DTO\UserDTO;
use App\Models\User;

class UserRepository
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function create(UserDTO $userData): User
    {
        return $this->userModel->create($userData->toArray());
    }
}
