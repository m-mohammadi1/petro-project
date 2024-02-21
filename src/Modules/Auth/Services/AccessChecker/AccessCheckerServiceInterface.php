<?php

namespace Modules\Auth\Services\AccessChecker;

use Modules\Auth\App\Models\User;

interface AccessCheckerServiceInterface
{
    public function isUserSuperAdmin(User $user): bool;
}
