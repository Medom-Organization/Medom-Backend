<?php

use Illuminate\Database\Seeder;
use Medom\Modules\Auth\Models\Role;
use Medom\Modules\Auth\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Seeding Roles Started" . PHP_EOL;
        Role::updateOrCreate(
            ['name' => 'superadmin', 'display_name' => "Super Administrator"],
            ['name' => "superadmin"]
        );

        Role::updateOrCreate(
            ['name' => 'hospital', 'display_name' => "Hospital"],
            ['name' => "hospital"]
        );
        Role::updateOrCreate(
            ['name' => 'doctor', 'display_name' => "Doctor"],
            ['name' => "doctor"]
        );
        Role::updateOrCreate(
            ['name' => 'secetary', 'display_name' => "HospitalSecetary"],
            ['name' => "secetary"]
        );
        Role::updateOrCreate(
            ['name' => 'employee', 'display_name' => "HospiatalEmployee"],
            ['name' => "employee"]
        );
        Role::updateOrCreate(
            ['name' => 'user', 'display_name' => "Registered User"],
            ['name' => "user"]
        );
        echo "Seeding Roles Finished" . PHP_EOL;

        // Seeding users
        echo "Seeding Users Started" . PHP_EOL;
        $superadmin = Role::where('name', 'superadmin')->first();
        User::updateOrCreate(
            [
                'first_name' => 'Daniel',
                'last_name' => "Mabadeje",
                'role_id' => $superadmin->_id,
                'email' => 'superadmin@medom.ng',
                'password' => bcrypt('password')
            ],
            ['email' => "superadmin@travellab.ng"]
        );
        User::updateOrCreate(
            [
                'first_name' => 'George',
                'last_name' => "Fabian",
                'role_id' => $superadmin->_id,
                'email' => 'george@travellab.ng',
                'password' => bcrypt('password')
            ],
            ['email' => "george@travellab.ng"]
        );
        echo "Seeding Users Finished" . PHP_EOL;
    }
}
