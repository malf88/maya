<?php

namespace App\Domain\Auth\Provider;

use App\Application\Abstracts\ServiceProviderAbstract;
use App\Domain\Auth\Business\UserBusiness;
use App\Domain\Auth\Interface\UserBusinessInterface;
use App\Domain\Auth\Interface\UserRepositoryInterface;
use App\Domain\Auth\Repository\UserRepository;

class AuthServiceProvider extends ServiceProviderAbstract
{
    public $bindings = [
        UserBusinessInterface::class => UserBusiness::class,
        UserRepositoryInterface::class => UserRepository::class
    ];
}
