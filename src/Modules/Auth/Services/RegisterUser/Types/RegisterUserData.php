<?php

namespace Modules\Auth\Services\RegisterUser\Types;

class RegisterUserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    )
    {
    }
}
