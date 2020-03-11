<?php

namespace Medom\Modules\Auth\Api\v1\Repositories;


use DB;
use Illuminate\Support\Facades\Mail;
use Medom\Mail\UserWelcomeMail;
use Medom\Mail\HospitalWelcomeMail;
use Medom\Modules\Auth\Models\Role;
use Medom\Modules\Auth\Models\Profile;
use Medom\Modules\Auth\Models\User;
use Medom\Modules\Hospitals\Models\Hospitals;
use Medom\Modules\Hospitals\Models\HospitalAdmin;
use Medom\Modules\Hospitals\Models\HospitalStaff;
use Medom\Modules\Hospitals\Models\Settingshospital;
use Medom\Modules\BaseRepository;
use Ramsey\Uuid\Uuid;

class AuthRepository extends BaseRepository
{
    public function __construct()
    {
        $this->roleModel = new Role;
        $this->userModel = new User;
        $this->hospitalModel = new Hospitals;
        $this->hospitalStaffModel = new HospitalStaff;
        $this->settingsHospitalModel = new Settingshospital;
        $this->hospitalAdminModel = new HospitalAdmin;
        $this->profileModel = new Profile;
    }

    public function sendWelcomeEmail($user, $password)
    {
        Mail::to($user->email)->later(now()->addSecond(5), new UserWelcomeMail($user, $password));
    }
    public function sendHospitalWelcomeEmail($user, $password)
    {

        Mail::to($user->email)->later(now()->addSecond(5), new HospitalWelcomeMail($user, $password));
    }
    public function getUserType($email)
    {
        $user = $this->userModel->where('email', $email)->first();
        $userid = $user->id;
        $usertype = $this->hospitalStaffModel->where('user_id', $userid)->first();
        if ($usertype) {
            $hospital = $this->hospitalModel->where('hospital_id', $usertype->hospital_id)->get();
            return $hospital;
        } else {
            return false;
        }
    }

    public function createUser($data, $profile_picture = null, $role_id = null)
    {
        if (!$role_id)
            $role = $this->roleModel->where('name', 'user')->first();
        $role_id = $role->id;
        $data->uniqueId=$this->generateUniqueId($data);
        dd($data->uniqueId);
        return $this->InsertUser($data, $role, $profile_picture);
    }

    public function createHospital($data, $profile_picture, $logo, $role_id = null)
    {
        $validatehospitalname = Settingshospital::where('hospitalname', $data['hospitalname'])->first();
        $validatehospitalid = Settingshospital::where('hid', $data['certificate_no'])->first();

        if (($validatehospitalname->hospitalname && $validatehospitalid->hid) !== null) {
            if (!$role_id) {
                $role = $this->roleModel->where('name', 'hospitaladmin')->first();
            }
            $user = $this->InsertUser($data, $role, $profile_picture);
            if ($user) {
                $hospital = $this->hospitalModel->create([
                    'hospital_id' => $this->generateUuid(),
                    'email' => $data['hospitalemail'],
                    'hospital_name' => $data['hospitalname'],
                    'address' => $data['address'],
                    'phone_no' => $data['phone_no'],
                    'certificate_no' => $data['certificate_no'],
                    'logo' => $logo,
                    'user_id' => $user->id
                ]);

                $hospitalstaff = $this->hospitalStaffModel->create([
                    'user_id' => $user->id,
                    'hospital_id' => $hospital->hospital_id,
                    'role_id' => $role->id
                ]);
                $hospitalAdmin = $this->hospitalAdminModel->create([
                    'user_id' => $user->id,
                    'hospital_id' => $hospital->hospital_id,
                    'role_id' => $role->id
                ]);
            }
            if (!$user)
                return false;

            // $this->sendHospitalWelcomeEmail($user, $data['password']);
            return array('user' => $user, 'hospital' => $hospital);
        } else {
            return false;
        }
    }

    //update account

    public function updateAccount($data)
    {
        if (is_array($data))
            $data = (object) $data;

        $user = auth()->user();

        $user->first_name = $data->first_name ? $data->first_name : $user->first_name;
        $user->surname = $data->surname ? $data->surname : $user->surname;

        return $user->save() ? $user : false;
    }


    //update profile
    public function updateProfile($data)
    {
        if (is_array($data))
            $data = (object) $data;

        $user = auth()->user();
        $profile = $this->profileModel->where('user_id', $user->id)->update([
            'phone_no' => $data['phone_no'],
            'marital_status' => $data['marital_status'],
            'DOB' => $data['DOB'],
            'address' => $data['address'],
            'genotype' => $data['genotype'],
            'blood_group' => $data['blood_group'],
            'height' => $data['height'],
            'weight' => $data['weight'],
            'religion' => $data['religion'],
            'next of kin' => $data['next of kin'],
        ]);
        if ($profile) {
            return true;
        } else {
            return false;
        }
    }

    public function generateUniqueId( $data )
    {
        $charset=$data->email;
        $unique=substr(str_shuffle(uniqid()),0,4);
        // rand(0000, 9999);
        return date('ymd').substr($charset, 0, 4). $unique;
        // return uniqid(date('ymd').substr($charset, 0, 4));
        // return uniqid(substr($charset, 0, 4), false );
    }
    //get by email
    public function getUserByEmail($email)
    {
        $user = $this->userModel->where('email', $email)->first();
        return $user;
    }
    public function InsertUser($data, $role, $profile_picture)
    {
        if($profile_picture==null){
            $profile_picture='profiles/profile.png.2018-04-24.1524590440.png';
        }
        $user = $this->userModel->create([
            'id' => $this->generateUuid(),
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'other_names' => $data['other_names'],
            'surname' => $data['surname'],
            'role_id' => $role->id,
            'role' => $role->name,
            'password' => bcrypt($data['password']),
            'profile_picture' => $profile_picture
        ]);
        $profile = $this->profileModel->create([
            'id' => $this->generateUuid(),
            'user_id' => $user->id,
            'bookings' => 0,
            'allergies' => 0,
            'wallet' => 0,
        ]);

        if (!$user)
            return false;

        //$this->sendWelcomeEmail($user, $data['password']);
        return $user;
    }
}
