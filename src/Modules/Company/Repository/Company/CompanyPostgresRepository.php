<?php

namespace Modules\Company\Repository\Company;

use Modules\Company\App\Models\Company;
use Modules\Shared\Repository\postgres\BasePostgresRepository;

class CompanyPostgresRepository extends BasePostgresRepository implements CompanyRepositoryInterface
{
    protected function getModel(): string
    {
        return Company::class;
    }
}
