<?php


namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;
class User extends Entity
{
    protected array $_accessible = [
        'email' => true,
        'password' => true,
    ];

    protected function _setPassword($password)
    {
        if (!empty($password)) {
            return (new DefaultPasswordHasher())->hash($password);
        }

        return null;
    }
}