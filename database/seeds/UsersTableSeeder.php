<?php

use Illuminate\Database\Seeder;
use Medom\Modules\Auth\Models\Role;
use Medom\Modules\Auth\Models\User;
use Ramsey\Uuid\Uuid;

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
            ['_id'=>Uuid::uuid4()->toString(), 'name' => 'superadmin', 'display_name' => "Super Administrator"],
            ['name' => "superadmin"]
        );

        Role::updateOrCreate(
            ['_id'=>Uuid::uuid4()->toString(), 'name' => 'hospital', 'display_name' => "Hospital"],
            ['name' => "hospital"]
        );
        Role::updateOrCreate(
            ['_id'=>Uuid::uuid4()->toString(), 'name' => 'doctor', 'display_name' => "Doctor"],
            ['name' => "doctor"]
        );
        Role::updateOrCreate(
            ['_id'=>Uuid::uuid4()->toString(), 'name' => 'secetary', 'display_name' => "HospitalSecetary"],
            ['name' => "secetary"]
        );
        Role::updateOrCreate(
            ['_id'=>Uuid::uuid4()->toString(), 'name' => 'employee', 'display_name' => "HospiatalEmployee"],
            ['name' => "employee"]
        );
        Role::updateOrCreate(
            ['_id'=>Uuid::uuid4()->toString(), 'name' => 'user', 'display_name' => "Registered User"],
            ['name' => "user"]
        );
        echo "Seeding Roles Finished" . PHP_EOL;

        // Seeding users
        echo "Seeding Users Started" . PHP_EOL;
        $superadmin = Role::where('name', 'superadmin')->first();
        User::updateOrCreate(
            [
                'id' => Uuid::uuid4()->toString(),
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
                'id' => Uuid::uuid4()->toString(),
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
