<?php

namespace Medom\Modules\Hospitals\Api\v1\Controllers;

// use Medom\Modules\Hospitals\Api\v1\Requests\UpdateProfileRequest;
use Medom\Modules\BaseController;
use Medom\Modules\Hospitals\Api\v1\Repositories\HospitalRepository;
use Illuminate\Http\Request;
use Medom\Modules\Hospitals\Api\v1\Requests\AddHospitalProfessionalRequest;
// use Medom\Modules\Hospitals\Api\v1\Requests\RegisterProfessionalRequest;
use Medom\Modules\Hospitals\Api\v1\Requests\AddHospitalStaffRequest;
// use Medom\Modules\Hospitals\Api\v1\Requests\HospitalRegistrationRequest;
// use Medom\Modules\Hospitals\Api\v1\Transformers\UserTransformer;
// use Medom\Modules\Hospitals\Api\v1\Transformers\RoleTransformer;

class HospitalController extends BaseController
{

    public function __construct(HospitalRepository $hospitalRepository)
    {
        $this->hospitalRepo = $hospitalRepository;
    }
    public function addHospitalAdmin()
    {
        $result = $this->hospitalRepo->addHospitalAdmin();
        return $result;
    }
    public function addHospitalProfessional(AddHospitalProfessionalRequest $request, $id)
    {
        $result = $this->hospitalRepo->addHospitalProfessional($request->all(), $id);
        // retur
        if ($result) {
            return $this->success("Professional added successfully");
        } else {
            return $this->fail("unale to add professional");
        }
    }
    public function addHospitalstaff(AddHospitalStaffRequest $request, $id)
    {
        $result = $this->hospitalRepo->addHospitalstaff($request->all(), $id);
        if ($result) {
            return $this->success("Hospital Staff added successfully");
        } else {
            return $this->fail("unale to add hospital staff");
        }
    }
    public function getHospitalProfessional()
    {
        $result = $this->hospitalRepo->getHospitalProfessional();
        return $result;
    }
    public function registerProfessional()
    {
        $result = $this->hospitalRepo->registerProfessional();
        if ($result) {
            return $this->success("Your Profile was updated to UnverifiedProfessional");
        }
    }
    public function getAllProfessionals()
    {
        $result = $this->hospitalRepo->getAllProfessionals();
        return $result;
    }
    public function getHospitals()
    {
        $result = $this->hospitalRepo->getHospitals();
        return $result;
    }
}
