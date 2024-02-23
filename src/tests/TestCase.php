<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function mockRepo(string $interface, string $repoName): mixed
    {
        $memory = new $repoName();
        $this->app->bind($interface, function () use ($memory) {
            return $memory;
        });
        return $memory;
    }
}
