<?php

namespace App\Domain\Auth\DTO;

use App\Application\Abstracts\DTOAbstract;

class UserDTO extends DTOAbstract
{
    public $id;
    public $username;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $address;
    public $city;
    public $country;
    public $postal;
    public $about;
}
