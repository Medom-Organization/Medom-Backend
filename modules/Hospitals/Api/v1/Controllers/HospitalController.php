<?php

namespace Medom\Modules\Hospitals\Api\v1\Controllers;

// use Medom\Modules\Hospitals\Api\v1\Requests\UpdateProfileRequest;
use Medom\Modules\BaseController;
use Medom\Modules\Hospitals\Api\v1\Repositories\HospitalRepository;
use Illuminate\Http\Request;
use Medom\Modules\Hospitals\Api\v1\Requests\AddHospitalProfessionalRequest;
use Medom\Modules\Hospitals\Api\v1\Requests\AddHospitalStaffRequest;
// use Medom\Modules\Hospitals\Api\v1\Requests\HospitalRegistrationRequest;
use Medom\Modules\Hospitals\Api\v1\Transformers\UserTransformer;
use Medom\Modules\Hospitals\Api\v1\Transformers\RoleTransformer;

class HospitalController extends BaseController
{

    public function __construct(HospitalRepository $hospitalRepository)
    {
        $this->hospitalRepo = $hospitalRepository;
    }
    public function addHospitalAdmin(Type $var = null)
    {
        $result=$this->hospitalRepo->addHospitalAdmin();
    }
    public function addHospitalProfessional(Type $request,$id)
    {
        $result=$this->hospital->addHospitalProfessional($request->all(), $id);
        // retur
    }
    public function addHospitalstaff(Type $var = null)
    {
        # code...
    }
    public function getHospitalProfessional(Type $var = null)
    {
        $result=$this->hospitalRepo->getHospitalProfessional();
    }
    public function registerProfessional()
    {
        $result=$this->hospitalRepo->registerProfessional();
        return $result;
    }
    public function getAllProfessionals()
    {
        $result=$this->hospitalRepo->getAllProfessional();
        return $result;
    }
}
