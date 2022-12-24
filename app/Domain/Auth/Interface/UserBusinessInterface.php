<?php

namespace App\Domain\Auth\Interface;

use App\Domain\Auth\DTO\UserDTO;

interface UserBusinessInterface
{
    public function create(UserDTO $userDTO):UserDTO;
    public function authUser(UserDTO $userDTO):bool;
    public function logoutUser():void;
    public function resetPasswordUser(UserDTO $userDTO):bool;
    public function updateUserWithoutPassword(UserDTO $user):bool;
}
