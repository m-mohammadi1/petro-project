<?php

namespace Modules\Company\Services\TruckManager;

use Illuminate\Contracts\Auth\Guard;
use Modules\Company\App\Models\Truck;
use Modules\Company\Repository\Company\CompanyRepositoryInterface;
use Modules\Company\Repository\Truck\TruckRepositoryInterface;
use Modules\Company\Services\TruckManager\Types\CreateTruckData;

class TruckManagerService implements TruckManagerServiceInterface
{
    public function __construct(
        private readonly Guard                      $guard,
        private readonly TruckRepositoryInterface   $truckRepository,
        private readonly CompanyRepositoryInterface $companyRepository,
    )
    {

    }


    public function addTruckToCompany(CreateTruckData $data): Truck
    {
        $authUser = $this->guard->user();
        $company = $this->companyRepository->find($data->company_id);

        if ($authUser->id != $company->admin_id) {
            throw new \Exception("only company admin can add truck for it.");
        }

        $truck = $this->truckRepository->create([
            'driver_name' => $data->driver_name,
            'company_id' => $company->id
        ]);

        return $truck;
    }

    public function deleteTruck(int $id): void
    {
        $authUser = $this->guard->user();
        $truck = $this->truckRepository->find($id);
        $company = $this->companyRepository->find($truck->company_id);

        if ($authUser->id != $company->admin_id) {
            throw new \Exception("only company admin can delete truck.");
        }

        $result = $this->truckRepository->delete($id);

        if (!$result) {
            throw new \Exception("cannot delete truck");
        }
    }
}
