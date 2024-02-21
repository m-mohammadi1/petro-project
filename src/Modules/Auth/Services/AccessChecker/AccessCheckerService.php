<?php

namespace Modules\Auth\Services\AccessChecker;

use Modules\Auth\App\Models\User;

class AccessCheckerService implements AccessCheckerServiceInterface
{
    public function isUserSuperAdmin(User $user): bool
    {
        return !$user->isNotSupperAdmin();
    }
}
