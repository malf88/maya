<?php

namespace App\Domain\Auth\Repository;

use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Interface\UserRepositoryInterface;
use App\Domain\Auth\Model\User;

class UserRepository implements UserRepositoryInterface
{

    public function create(UserDTO $userDTO): UserDTO
    {
        $user = new User($userDTO->toArray());
        $user->save();
        return new UserDTO($user->toArray());
    }

    public function find(int $userId): UserDTO
    {
        $user = User::find($userId);
        return new UserDTO($user->toArray());
    }

    public function findByEmail(string $email): ?UserDTO
    {
        $user = User::where('email', $email)->first();
        if($user)
            return new UserDTO($user->toArray());
        return null;
    }

    public function update(UserDTO $userDTO): bool
    {

        $user = User::find($userDTO->id);
        $user->fill($userDTO->toArray());

        return $user->update();
    }
}
