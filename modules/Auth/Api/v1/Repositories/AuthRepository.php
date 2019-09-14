<?php

namespace Medom\Modules\Auth\Api\v1\Repositories;


use DB;
use Illuminate\Support\Facades\Mail;
use Medom\Mail\UserWelcomeMail;
use Medom\Modules\Auth\Models\Role;
use Medom\Modules\Auth\Models\User;
use Medom\Modules\BaseRepository;

class AuthRepository extends BaseRepository
{
    public function __construct()
    {
        $this->roleModel = new Role;
        $this->userModel = new User;
    }

    public function getUsers()
    {
        return $this->userModel->get();
    }

    public function getUserByEmail($email)
    {
        $user = $this->userModel->where('email',$email)->first();
        return $user;
    }

    public function getRoles()
    {
        return $this->roleModel->get();
    }

    public function createAdmin($data)
    {
        $user = $this->userModel->create([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role_id' => $data['role'],
            'password' => bcrypt('password')
        ]);
        
        if(!$user)
            return false;
        
        return $user;
    }


    public function sendWelcomeEmail($user,$password){

        Mail::to($user->email)->later(now()->addSecond(5),new UserWelcomeMail($user,$password));
    }

    public function createUser($data,$role_id=null)
    {
        if(!$role_id){
            $role = $this->roleModel->where('name','user')->first();
            $role_id = $role->id;
        }
        $user = $this->userModel->create([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role_id' => $role_id,
            'role'=>$role->name,
            'password' => bcrypt($data['password'])
        ]);

        if(!$user)
            return false;

        $this->sendWelcomeEmail($user,$data['password']);
        return $user;

    }



    public function updateAccount($data){
        if(is_array($data))
            $data = (object)$data;

        $user = auth()->user();

        $user->first_name = $data->first_name?$data->first_name:$user->first_name;
        $user->last_name = $data->last_name?$data->last_name:$user->last_name;

        return $user->save()?$user:false;

    }
    // public function register($data){
        

    // }

}