<?php

namespace Modules\Auth\Services\RegisterUser;

use Modules\Auth\App\Models\User;
use Modules\Auth\Services\RegisterUser\Exceptions\RegisterUserException;
use Modules\Auth\Services\RegisterUser\Types\RegisterUserData;

interface RegisterUserServiceInterface
{

    /**
     * @throws RegisterUserException
     */
    public function register(RegisterUserData $data): User;
}
