<?php

namespace App\Exceptions\User;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'Пользователь не найден';

    protected $code = 404;
}
