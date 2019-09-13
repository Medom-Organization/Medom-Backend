<?php

namespace Medom\Modules\Admin\Api\v1\Repositories;


use DB;
use Illuminate\Support\Facades\Mail;
use Medom\Mail\UserWelcomeMail;
use Medom\Modules\Auth\Models\Role;
use Medom\Modules\Auth\Models\User;
use Medom\Modules\Booking\Models\Order;
use Medom\Modules\Booking\Models\Payment;
use Medom\Modules\BaseRepository;
use Carbon\Carbon;

class AdminRepository extends BaseRepository
{
    public function __construct()
    {
        $this->roleModel = new Role;
        $this->userModel = new User;
        $this->orderModel = new Order;
        $this->paymentModel = new Payment;
    }

    public function getUsers()
    {
        $users = User::paginate(15);
        return $users;
    }
    public function getUsersType($roles)
    {
        $roleid = $this->roleModel->where('name', $roles[0])->value('_id');
        $users = $this->userModel->where('role_id', $roleid)->paginate(10);
        return $users;
    }

    public function getUserByEmail($email)
    {
        $user = $this->userModel->where('email', $email)->first();
        return $user;
    }

    public function getRoles()
    {
        return $this->roleModel->get();
    }

    public function createEmployee($data)
    {
        $user = $this->userModel->create([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role_id' => $data['role'],
            'password' => bcrypt('password')
        ]);

        if (!$user)
            return false;

        return $user;
    }


    public function sendWelcomeEmail($user, $password)
    {

        Mail::to($user->email)->later(now()->addSecond(5), new UserWelcomeMail($user, $password));
    }

    public function createUser($data, $role_id = null)
    {
        if (!$role_id) {
            $role = $this->roleModel->where('name', 'user')->first();
            $role_id = $role->id;
        }
        $user = $this->userModel->create([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role_id' => $role_id,
            'password' => bcrypt($data['password'])
        ]);

        if (!$user)
            return false;

        $this->sendWelcomeEmail($user, $data['password']);
        return $user;
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
    public function updateAccountbyId($data, $id)
    {
        if (is_array($data)) {
            $data = (object) $data;
        } else { }
        $user = $this->userModel->findorfail($id);
        $user->update([
            "first_name" => $data->first_name,
            "last_name"  => $data->last_name,
        ]);
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
    public function delete($id)
    {
        $delete = $this->userModel->delete($id);
        return $delete;
    }
    public function metrics()
    {
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $roleid = $this->roleModel->where('name', 'user')->value('_id');
        $customer = $this->userModel->where('role_id', $roleid)->count();
        $allUsers = $this->userModel->count();
        // $totalbookings = $this->orderModel->count();
        // $amount = $this->paymentModel->sum('amount');
        $year = date('Y');
        $date = date('Y-m-d');

        $yearlyincome = $this->paymentModel->whereBetween('created_at', array($year . "01-01", $year . "12-31"))->sum('amount');
        $monthlyincome = $this->paymentModel->whereBetween('created_at', array(new Carbon('first day of this month'), new Carbon('last day of this month')))->sum('amount');
        $dailyincome = $this->paymentModel->where('created_at', $date)->sum('amount');
        $transactions = array("this_year" => $yearlyincome, "this_month" => $monthlyincome, "today" => $dailyincome);
        $users=array("total_users"=>$allUsers, "customers"=>$customer);

        
        foreach ($months as $month) {
            $paymentmetrics[$month] = $this->paymentModel->whereBetween('created_at', [new Carbon('first day of ' . $month), new Carbon('last day of ' . $month)])->sum('amount');
            $bookingmetrics[$month]=$this->orderModel->whereBetween('created_at', [new Carbon('first day of ' . $month), new Carbon('last day of ' . $month)])->count();
        }
        return response()->json(["status" => "success",  "transactions"=>$transactions, "users"=>$users, "chart"=>["bookings" => $bookingmetrics, "payments" => $paymentmetrics]]);
    }
}
