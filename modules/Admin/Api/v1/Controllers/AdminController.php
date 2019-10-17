<?php

namespace Medom\Modules\Admin\Api\v1\Controllers;

use Medom\Modules\Auth\Api\v1\Requests\UpdateProfileRequest;
use Medom\Modules\BaseController;
use Medom\Modules\Admin\Api\v1\Repositories\AdminRepository;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Medom\Modules\Auth\Api\v1\Requests\LoginRequest;
use Medom\Modules\Auth\Api\v1\Transformers\UserTransformer;
use Medom\Modules\Auth\Api\v1\Transformers\RoleTransformer;
use Medom\Modules\Auth\Models\User;

class AdminController extends BaseController
{

    public function __construct(AdminRepository $adminRepo, UserTransformer $userTransformer)
    {
        $this->adminRepo = $adminRepo;
        $this->userTransformer = $userTransformer;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        // $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->fail("Invalid login credentials");
        }

        $data = [
            'token' => $token,
            'user' => auth()->user()
        ];
        return $this->success($data);
    }

    public function addEmployee(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);

        $data = $request->all();
        $user = $this->adminRepo->createEmployee($data);

        if ($user) {
            # code...
        }
        $data = [
            'message' => 'Employee Added Successful',
        ];

        return $this->success($data);
    }

    public function getUsers(UserTransformer $transformer)
    {
        $users = $this->adminRepo->getUsers();
        // return $users;
        return $this->successWithPages($users, $transformer);
    }
    public function getUsersType(UserTransformer $transformer, Request $request)
    {
        $types = explode(',', $request->get('role'));
        $users = $this->adminRepo->getUsersType($types);
        return $this->successWithPages($users, $transformer);
    }

    public function getRoles(RoleTransformer $transformer)
    {
        $roles = $this->adminRepo->getRoles();
        return $this->transform($roles, $transformer);
    }


    public function updateProfile(UpdateProfileRequest $request)
    {

        $user = $this->adminRepo->updateAccount($request->all());

        if ($user)
            return $this->transform($user, $this->userTransformer);

        return $this->error("Unable to update user profile");
    }
    public function updateProfilebyId(UpdateProfileRequest $request, $id)
    {

        $user = $this->adminRepo->updateAccountbyId($request->all(), $id);

        if ($user)
            return $this->transform($user, $this->userTransformer);

        return $this->error("Unable to update user profile");
    }
    public function delete($id)
    {
        $delete = $this->adminRepo->delete($id);
        if ($delete)
            return "deleted successfully";

        return $this->error("cannot delete user");
    }
    public function metrics()
    {
        $metrics = $this->adminRepo->metrics();
        if ($metrics) {
            return $metrics;
        } else {
            return $this->error("An error occured");
        }
    }
    public function addSuperAdmin(Request $request)
    {
        $this->validate($request, [
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
}
