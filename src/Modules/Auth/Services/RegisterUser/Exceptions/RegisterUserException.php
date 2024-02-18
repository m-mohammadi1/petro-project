<?php

namespace Modules\Auth\Services\RegisterUser\Exceptions;

class RegisterUserException extends \Exception
{
    public static function throwBecauseUserExists()
    {
        throw new self("user already registered with the same id.");
    }
}
