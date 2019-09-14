<?php

namespace Medom\Modules\Auth\Api\v1\Controllers;

use Medom\Modules\Auth\Api\v1\Requests\UpdateProfileRequest;
use Medom\Modules\BaseController;
use Medom\Modules\Auth\Api\v1\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Medom\Modules\Auth\Api\v1\Requests\LoginRequest;
use Medom\Modules\Auth\Api\v1\Requests\RegistrationRequest;
use Medom\Modules\Auth\Api\v1\Transformers\UserTransformer;
use Medom\Modules\Auth\Api\v1\Transformers\RoleTransformer;

class AuthController extends BaseController
{

    public function __construct(AuthRepository $authRepo,UserTransformer $userTransformer)
    {
        $this->authRepo = $authRepo;
        $this->userTransformer = $userTransformer;

    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        // $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->fail("Invalid login credentials");
        }

        $data = [
            'token'=>$token,
            'user'=>auth()->user()
        ];

        return $this->success($data);

    }

    public function addSuperAdmin(Request $request)
    {        
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);

        $data = $request->all();
        $user = $this->authRepo->createAdmin($data);
        
        if ($user) {
            # code...
        }
        $data = [
            'message' => 'Admin Added Successful',
        ];

        return $this->success($data);

    }

    public function registerUser(RegistrationRequest $request)
    {
        $user =$this->authRepo->createUser($request);
    }
    // public function registerHospital(HospitalRegistrationRequest $request)
    // {
    //     $user =$this->authRepo->createHospital($request);
    // }
    public function getUsers(UserTransformer $transformer)
    {
        $users = $this->authRepo->getUsers();
        return $this->transform($users,$transformer);
    }

    public function getRoles(RoleTransformer $transformer)
    {
        $roles = $this->authRepo->getRoles();
        return $this->transform($roles, $transformer);
    }


    public function updateProfile(UpdateProfileRequest $request){

        $user = $this->authRepo->updateAccount($request->all());

        if($user)
            return $this->transform($user,$this->userTransformer);

        return $this->error("Unable to update user profile");
    }

}
