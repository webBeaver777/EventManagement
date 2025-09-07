<?php

namespace App\Exceptions\User;

use Exception;

class UserAuthFailedException extends Exception
{
    protected $message = 'Неверный логин или пароль';

    protected $code = 401;
}
