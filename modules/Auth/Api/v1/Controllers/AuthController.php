<?php

namespace Medom\Modules\Auth\Api\v1\Controllers;

use Medom\Modules\Auth\Api\v1\Requests\updateAccountRequest;
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
        // dd($request['email']);
        $email=$this->getUserEmail($request['email']);
        $request['email']=$email[0]->email;
        // dd($request->only('email', 'password'));
        // die($email[0]->email);
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->attempt($credentials)) {
            return $this->fail("Invalid login credentials");
        }
        $userType = $this->getUserType($request['email']);
        // to check if the user works with a hospital
        if ($userType) {
            $data = [
                'token' => $token,
                'user' => auth()->user(),
                'hospital' => $userType
            ];
        } else {
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

    public function getUserEmail($data)
    {
        return $this->authRepo->getUserEmail($data);
    }
    public function registerUser(RegistrationRequest $request)
    {
        if (isset($request->profile_picture)) {
            $profile_picture = $request->profile_picture->store('profiles', 'public');
            $user = $this->authRepo->createUser($request, $profile_picture);
            // return $user;
            return $this->transform($user, $this->userTransformer);
        } else {
            $user = $this->authRepo->createUser($request);
            // return $user;
            return $this->transform($user, $this->userTransformer);
        }
    }
    public function registerHospital(HospitalRegistrationRequest $request)
    {
        $profile_picture = $request->profile_picture->store('profiles', 'public');

        $logo = $request->logo->store('logos', 'public');
        $check = $this->authRepo->createHospital($request, $profile_picture, $logo);
        if ($check) {
            return $check;
        } else {
            return $this->fail("registration failed");
        }
    }

    public function updateAccount(updateAccountRequest $request)
    {

        $user = $this->authRepo->updateAccount($request->all());

        if ($user)
            return $this->transform($user, $this->userTransformer);

        return $this->error("Unable to update user profile");
    }


    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->authRepo->updateProfile($request->all());

        if ($user)
            return $this->transform($user, $this->userTransformer);

        return $this->error("Unable to update user profile");
    }
}
