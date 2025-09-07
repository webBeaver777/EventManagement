<?php

namespace App\Exceptions\Event;

use Exception;

class AlreadyJoinedException extends Exception
{
    protected $message = 'Вы уже участвуете в этом событии';

    protected $code = 409;
}
