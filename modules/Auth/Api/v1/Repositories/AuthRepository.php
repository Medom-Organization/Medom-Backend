<?php

namespace Medom\Modules\Auth\Api\v1\Repositories;


use DB;
use Illuminate\Support\Facades\Mail;
use Medom\Mail\UserWelcomeMail;
use Medom\Modules\Auth\Models\Role;
use Medom\Modules\Auth\Models\User;
use Medom\Modules\Hospitals\Models\Hospitals;
use Medom\Modules\Hospitals\Models\HospitalStaff;
use Medom\Modules\BaseRepository;

class AuthRepository extends BaseRepository
{
    public function __construct()
    {
        $this->roleModel = new Role;
        $this->userModel = new User;
        $this->hospitalModel = new Hospitals;
        $this->hospitalStaffModel = new HospitalStaff;
    }

    public function sendWelcomeEmail($user, $password)
    {

        Mail::to($user->email)->later(now()->addSecond(5), new UserWelcomeMail($user, $password));
    }
    public function getUserType($email)
    {
        $user = $this->userModel->where('email', $email);
        $roleid = $user->roleid;
        $userid = $user->id;
        $usertype = $this->hospitalStaffModel->where('user_id', $userid);
        if ($usertype) {
            $hospital[] = $this->hospitalModel->where('id', $usertype->id);
            return $hospital;
        } else {
            return false;
        }
    }

    public function createUser($data, $profile_picture, $role_id = null)
    {
        if (!$role_id) {
            $role = $this->roleModel->where('name', 'user')->first();
            $role_id = $role->_id;
        }
        $user = $this->userModel->create([
            'id' => $this->generateUuid(),
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role_id' => $role_id,
            'role' => $role->name,
            'password' => bcrypt($data['password']),
            'profile_picture' => $profile_picture
        ]);

        if (!$user)
            return false;

        $this->sendWelcomeEmail($user, $data['password']);
        return $user;
    }

    public function createHospital($data, $profile_picture, $logo, $role_id = null)
    {
        if (!$role_id) {
            $role = $this->roleModel->where('name', 'hospitaladmin')->first();
            $role_id = $role->_id;
        }
        $user = $this->userModel->create([
            'id' => $this->generateUuid(),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'role_id' => $role_id,
            'password' => bcrypt($data['password']),
            'role' => $role->name,
            'profile_picture' => $profile_picture
        ]);
        // dd($user->id);
        // dd($user);
        $user_id=$this->userModel->where('email', $user->email)->get();
        dd($user_id->id);

        return $user;
        if ($user) {
            $hospital = $this->hospitalModel->create([
                'id' => $this->generateUuid(),
                'email' => $data['hospitalemail'],
                'hospital_name' => $data['hospitalname'],
                'address' => $data['address'],
                'phone_no' => $data['phone_no'],
                'certificate_no' => $data['certificate_no'],
                'logo' => $logo,
                'user_id' => $user->id
            ]);
            // dd($user->id);
            $hospitalstaff = $this->hospitalStaffModel->create([
                'user_id' => $user->id,
                'hospital' => $hospital->id,
                'role_id' => $role_id
            ]);
        }
        if (!$user)
            return false;

        $this->sendWelcomeEmail($user, $data['password']);
        return array('user' => $user, 'hospital' => $hospital);
    }



    public function updateAccount($data)
    {
        if (is_array($data))
            $data = (object) $data;

        $user = auth()->user();

        $user->first_name = $data->first_name ? $data->first_name : $user->first_name;
        $user->last_name = $data->last_name ? $data->last_name : $user->last_name;

        return $user->save() ? $user : false;
    }
    // public function register($data){


    // }

}
