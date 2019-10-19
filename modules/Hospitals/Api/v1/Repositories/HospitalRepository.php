<?php

namespace Medom\Modules\Hospitals\Api\v1\Repositories;


use DB;
use Illuminate\Support\Facades\Mail;
use Medom\Mail\UserWelcomeMail;
use Medom\Modules\Auth\Models\Role;
use Medom\Modules\Auth\Models\User;
use Medom\Modules\Hospitals\Models\Hospitals;
use Medom\Modules\Hospitals\Models\HospitalAdmin;
use Medom\Modules\Hospitals\Models\HospitalStaff;
use Medom\Modules\Hospitals\Models\Settingshospital;
use Medom\Modules\Hospitals\Models\Professional;
use Medom\Modules\BaseRepository;
use Ramsey\Uuid\Uuid;
use Medom\Modules\Hospitals\Models\HospitalProfessional;

class HospitalRepository extends BaseRepository
{
    public function __construct()
    {
        $this->roleModel = new Role;
        $this->userModel = new User;
        $this->hospitalModel = new Hospitals;
        $this->hospitalStaffModel = new HospitalStaff;
        $this->settingsHospitalModel = new Settingshospital;
        $this->hospitalAdminModel = new HospitalAdmin;
        $this->hospitalProfessional = new HospitalProfessional;
        $this->Professional = new Professional;
    }


    public function getHospitalProfessional()
    {
        $result = $this->hospitalProfessional->all();
        foreach ($result as $result) {
            $data[] =$this->userModel->where('id', $result->id);
        }
        return $data;
    }
    public function addHospitalProfessional($request, $id)
    {
        $user = auth()->user();
        $validatehospitaladmin = $this->hospitalAdminModel->where('user_id', $user->id)->get();
        if ($validatehospitaladmin) {
            $hospital_id = $this->hospitalModel->where('name', $request['hospitalname'])->get();
        } else {
            return response()->json(['status' => false, 'message' => 'Access Denied'], 401);
        }
        $check = $this->Professional->where('id', $id)->get();
        $role = $this->roleModel->where('name', 'hospitalprofessional')->get();
        if ($check) {
            $professional = $this->Professional->where('id', $id)->update([
                'role_id' => $role->id,
                'status' => 'verified',
            ]);
            $hospitalProfessional = $this->hospitalProfessional->create([
                'user_id' => $id,
                'hospital_id' => $hospital_id->id,
                'role_id' => $role->id,
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'professional not found'], 500);
        }

        // ret
    }
    public function registerProfessional()
    {
        $user = auth()->user();
        $role = $this->roleModel->where('name', 'unverifiedProfessional')->first();
        // dd($role);
        $updateuser=$this->userModel->where('id', $user->id)->update([
            'role_id' => $role->id,
            'role' => $role->name
        ]);
        $professional = $this->Professional->updateorcreate([
            'user_id' => $user->id,
            'role_id' => $role->id,
            'status' => 'unverified'
        ]);
        if($updateuser && $professional){
            return true;
        }else{
            return false;
        }
        
    }
    public function getAllProfessionals()
    {
        $result= $this->Professional::all();
        foreach($result as $result){
            $data[]=$this->userModel->where('id', $result->user_id)->get();
        }
return $data;
    }
    public function getHospitals(){
        return $this->hospitalModel::all();
    }
}
