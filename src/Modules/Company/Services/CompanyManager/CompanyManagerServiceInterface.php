<?php

namespace Modules\Company\Services\CompanyManager;

use Modules\Auth\App\Models\User;
use Modules\Company\App\Models\Company;

interface CompanyManagerServiceInterface
{
    public function createCompany(string $name, User $admin): Company;

    public function deleteCompany(int $id): void;
}
