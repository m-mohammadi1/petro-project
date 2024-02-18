<?php

namespace Modules\Auth\Services\RegisterUser;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Models\User;
use Modules\Auth\Repository\User\UserRepositoryInterface;
use Modules\Auth\Services\RegisterUser\Exceptions\RegisterUserException;
use Modules\Auth\Services\RegisterUser\Types\RegisterUserData;

class RegisterUserService implements RegisterUserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    )
    {
    }

    /**
     * @throws RegisterUserException
     */
    public function register(RegisterUserData $data): User
    {
        // check for email not to be repetitive
        $existingUser = $this->userRepository->all([
            'email' => $data->email
        ])->first();

        if ($existingUser) {
            RegisterUserException::throwBecauseUserExists();
        }

        // hash password
        $normalizedData = [
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ];

        // save it
        return $this->userRepository->create($normalizedData);
    }
}
