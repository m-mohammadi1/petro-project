<?php

namespace Modules\Company\Services\CompanyManager;

use Illuminate\Contracts\Auth\Guard;
use Modules\Auth\App\Models\User;
use Modules\Auth\Services\AccessChecker\AccessCheckerServiceInterface;
use Modules\Company\App\Models\Company;
use Modules\Company\Repository\Company\CompanyRepositoryInterface;

class CompanyManagerService implements CompanyManagerServiceInterface
{
    public function __construct(
        private readonly Guard                         $guard,
        private readonly AccessCheckerServiceInterface $accessCheckerService,
        private readonly CompanyRepositoryInterface    $companyRepository,
    )
    {
    }

    public function createCompany(string $name, User $admin): Company
    {
        $this->checkPermissions();

        $company = $this->companyRepository->create([
            'name' => $name,
            'admin_id' => $admin->id
        ]);

        return $company;
    }

    public function deleteCompany(int $id): void
    {
        $this->checkPermissions();

        $result = $this->companyRepository->delete($id);

        if (!$result) {
            throw new \Exception("cannot delete company");
        }
    }


    public function checkPermissions(): void
    {
        /** @var User $user */
        $user = $this->guard->user();

        if (!$this->accessCheckerService->isUserSuperAdmin($user)) {
            throw new \Exception("only super admin can create company");
        }
    }
}
