<?php

namespace App\Exceptions\Event;

use Exception;

class ForbiddenException extends Exception
{
    protected $message = 'Нет прав на выполнение действия';

    protected $code = 403;
}
