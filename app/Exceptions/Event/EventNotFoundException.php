<?php

namespace App\Exceptions\Event;

use Exception;

class EventNotFoundException extends Exception
{
    protected $message = 'Событие не найдено';

    protected $code = 404;
}
