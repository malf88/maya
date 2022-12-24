<?php

namespace App\Domain\Auth\Business;

use App\Application\Abstracts\AuthAbstract;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Interface\UserBusinessInterface;
use App\Domain\Auth\Interface\UserRepositoryInterface;
use App\Notifications\ForgotPassword;
use http\Exception\InvalidArgumentException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Request;

class UserBusiness implements UserBusinessInterface
{
    use Notifiable;
    private string $emailNotifiable;
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    public function create(UserDTO $userDTO):UserDTO
    {
        return $this->userRepository->create($userDTO);
    }

    public function authUser(UserDTO $userDTO):bool
    {
        return AuthAbstract::attempt(['email' => $userDTO->email, 'password' =>$userDTO->password]);
    }

    public function logoutUser():void
    {
        AuthAbstract::logout();
    }

    public function resetPasswordUser(UserDTO $userDTO):bool
    {
        $user = $this->userRepository->findByEmail($userDTO->email);
        $this->setEmailNotifiable($user->email);
        if ($user) {
            $this->notify(new ForgotPassword($user->id));
            return true;
        }
    }

    public function routeNotificationForMail() {
        if(!$this->getEmailNotifiable())
            throw new InvalidArgumentException('E-mail notifiable undefined');
        return $this->getEmailNotifiable();
    }

    public function updatePasswordUser(UserDTO $userDTO):bool
    {
        $existingUser = $this->userRepository->findByEmail($userDTO->email);
        if ($existingUser) {
            $existingUser->password = $userDTO->password;
            return $this->userRepository->update($existingUser);
        }
        return false;
    }

    public function updateUserWithoutPassword(UserDTO $user):bool
    {
        $fullUser = $this->userRepository->find($user->id);
        $user->password = $fullUser->password;
        return $this->userRepository->update($user);
    }

    public function setEmailNotifiable(string $email):void
    {
        $this->emailNotifiable = $email;
    }
    public function getEmailNotifiable():string
    {
        return $this->emailNotifiable;
    }
}
