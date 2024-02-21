<?php

namespace Modules\Company\Repository\Company;

use Modules\Company\App\Models\Company;
use Modules\Shared\Repository\memory\BaseMemoryRepository;

class CompanyMemoryRepository extends BaseMemoryRepository implements CompanyRepositoryInterface
{
    protected function getModel(): string
    {
        return Company::class;
    }
}
