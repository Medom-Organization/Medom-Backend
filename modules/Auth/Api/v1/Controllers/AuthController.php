<?php

namespace Medom\Modules\Auth\Api\v1\Controllers;

use Medom\Modules\Auth\Api\v1\Requests\UpdateProfileRequest;
use Medom\Modules\BaseController;
use Medom\Modules\Auth\Api\v1\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Medom\Modules\Auth\Api\v1\Requests\LoginRequest;
use Medom\Modules\Auth\Api\v1\Requests\RegistrationRequest;
use Medom\Modules\Auth\Api\v1\Requests\HospitalRegistrationRequest;
use Medom\Modules\Auth\Api\v1\Transformers\UserTransformer;
use Medom\Modules\Auth\Api\v1\Transformers\RoleTransformer;

class AuthController extends BaseController
{

    public function __construct(AuthRepository $authRepo, UserTransformer $userTransformer)
    {
        $this->authRepo = $authRepo;
        $this->userTransformer = $userTransformer;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        // $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->fail("Invalid login credentials");
        }

        $userType=$this->getUserType($request['email']);
        if($userType){
        $data = [
            'token' => $token,
            'user' => auth()->user(),
            'hospital'=>$userType
        ];
    }else{
        $data = [
            'token' => $token,
            'user' => auth()->user()
        ];
    }

        return $this->success($data);
    }

    public function getUserType($email)
    {
        return $this->authRepo->getUserType($email);
    }
    public function registerUser(RegistrationRequest $request)
    {
        
        $this->validate($request, [

            // 'po' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
            $profile_picture=$request->profile_picture->store('Profiles');
        $user = $this->authRepo->createUser($request, $profile_picture);
    }
    public function registerHospital(HospitalRegistrationRequest $request)
    {
        $this->validate($request, [

            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:100000',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:100000'

        ]);
        // foreach ($request->profile_picture as $photo) {
        $profile_picture=$request->profile_picture->store('Profiles');
        // $profile_picture=$photo->store('Profiles');
        // }
        // foreach ($request->logo as $photo) {
        $logo = $request->logo->store('logos');
        // $logo = $photo->store('logos');
        // }
        return $this->authRepo->createHospital($request, $profile_picture, $logo);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {

        $user = $this->authRepo->updateAccount($request->all());

        if ($user)
            return $this->transform($user, $this->userTransformer);

        return $this->error("Unable to update user profile");
    }
}
