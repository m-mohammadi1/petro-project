<?php

namespace Tests\Unit\RegisterUser;

use Modules\Auth\Repository\User\UserMemoryRepository;
use Modules\Auth\Services\RegisterUser\Exceptions\RegisterUserException;
use Modules\Auth\Services\RegisterUser\RegisterUserService;
use Modules\Auth\Services\RegisterUser\Types\RegisterUserData;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    public function test_it_can_register_user(): void
    {
        $memory = new UserMemoryRepository();
        $service = new RegisterUserService($memory);

        $userRegistered = $service->register(new RegisterUserData(
            "Mohammad Mohammadi",
            "mohammad@mohammadi.com",
            "12345678"
        ));


        // check to see if it is stored correctly in database
        $userStored = $memory->find($userRegistered->id);

        $this->assertNotNull($userStored);
        $this->assertEquals($userRegistered->name, $userStored->name);
        $this->assertEquals($userRegistered->email, $userStored->email);
    }

    public function test_it_can_prevent_repetitive_email_to_be_registered(): void
    {
        $memory = new UserMemoryRepository();
        $service = new RegisterUserService($memory);

        $service->register(new RegisterUserData(
            "Mohammad Mohammadi",
            "mohammad@mohammadi.com",
            "12345678"
        ));
        $service->register(new RegisterUserData(
            "Random",
            "random@random.com",
            "12345678"
        ));

        // user with same email
        $this->expectException(RegisterUserException::class);
        $service->register(new RegisterUserData(
            "Mohammad 2",
            "mohammad@mohammadi.com",
            "12345678"
        ));
    }
}
