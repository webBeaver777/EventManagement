<?php

namespace App\Exceptions\Event;

use Exception;

class NotParticipantException extends Exception
{
    protected $message = 'Вы не являетесь участником события';

    protected $code = 404;
}
