<?php

namespace App\Domain\Auth\Interface;

use App\Domain\Auth\DTO\UserDTO;

interface UserRepositoryInterface
{
    public function create(UserDTO $userDTO): UserDTO;
    public function find(int $userId): UserDTO;
    public function findByEmail(string $email):?UserDTO;
    public function update(UserDTO $userDTO): bool;
}
