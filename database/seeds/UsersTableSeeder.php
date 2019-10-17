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
            ['_id' => Uuid::uuid4()->toString(), 'name' => 'superadmin', 'display_name' => "Super Administrator"],
            ['name' => "superadmin"]
        );

        Role::updateOrCreate(
            ['_id' => Uuid::uuid4()->toString(), 'name' => 'hospitaladmin', 'display_name' => "Hospital"],
            ['name' => "hospitaladmin"]
        );
        Role::updateOrCreate(
            ['_id' => Uuid::uuid4()->toString(), 'name' => 'hospitalprofessional', 'display_name' => "HospitalProfessional"],
            ['name' => "hospitalprofessional"]
        );
        Role::updateOrCreate(
            ['_id' => Uuid::uuid4()->toString(), 'name' => 'hospitalstaff', 'display_name' => "HospitalStaff"],
            ['name' => "hospitalstaff"]
        );
        Role::updateOrCreate(
            ['_id' => Uuid::uuid4()->toString(), 'name' => 'unverifiedProfessional', 'display_name' => "unverifiedProfessional"],
            ['name' => "unverifiedProfessional"]
        );
        Role::updateOrCreate(
            ['_id' => Uuid::uuid4()->toString(), 'name' => 'user', 'display_name' => "Registered User"],
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
                'role' => $superadmin->name,
                'password' => bcrypt('password')
            ],
            ['email' => "superadmin@medom.ng"]
        );
        User::updateOrCreate(
            [
                'id' => Uuid::uuid4()->toString(),
                'first_name' => 'Dynasty',
                'last_name' => "Emmanuel",
                'role_id' => $superadmin->_id,
                'role' => $superadmin->name,
                'email' => 'dynasty@medom.ng',
                'password' => bcrypt('password')
            ],
            ['email' => "dynasty@medom.ng"]
        );
        echo "Seeding Users Finished" . PHP_EOL;
    }
}
