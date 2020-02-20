<?php

use Illuminate\Database\Seeder;
use Medom\Modules\Auth\Models\Role;
use Medom\Modules\Auth\Models\User;
use Medom\Modules\Auth\Models\Profile;
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
            ['id' => Uuid::uuid4()->toString(), 'name' => 'superadmin', 'display_name' => "Super Administrator", "description" => 'arole'],
            ['name' => "superadmin"]
        );

        Role::updateOrCreate(
            ['id' => Uuid::uuid4()->toString(), 'name' => 'hospitaladmin', 'display_name' => "Hospital", "description" => 'arole'],
            ['name' => "hospitaladmin"]
        );
        Role::updateOrCreate(
            ['id' => Uuid::uuid4()->toString(), 'name' => 'hospitalprofessional', 'display_name' => "HospitalProfessional", "description" => 'arole'],
            ['name' => "hospitalprofessional"]
        );
        Role::updateOrCreate(
            ['id' => Uuid::uuid4()->toString(), 'name' => 'hospitalstaff', 'display_name' => "HospitalStaff", "description" => 'arole'],
            ['name' => "hospitalstaff"]
        );
        Role::updateOrCreate(
            ['id' => Uuid::uuid4()->toString(), 'name' => 'unverifiedProfessional', 'display_name' => "unverifiedProfessional", "description" => 'arole'],
            ['name' => "unverifiedProfessional"]
        );
        Role::updateOrCreate(
            ['id' => Uuid::uuid4()->toString(), 'name' => 'user', 'display_name' => "Registered User", "description" => 'arole'],
            ['name' => "user"]
        );
        echo "Seeding Roles Finished" . PHP_EOL;

        // Seeding users
        echo "Seeding Users Started" . PHP_EOL;
        $superadmin = Role::where('name', 'superadmin')->first();
        $user = User::updateOrCreate(
            [
                'id' => Uuid::uuid4()->toString(),
                'first_name' => 'Daniel',
                'surname' => "Mabadeje",
                'role_id' => $superadmin->id,
                'email' => 'mabadejedaniel1@medom.ng',
                'role' => $superadmin->name,
                'password' => bcrypt('password')
            ]
        );
        Profile::updateOrCreate([
            'id'=>Uuid::uuid4()->toString(),
            'user_id'=>$user->id,
            'bookings' => 0,
            'allergies' => 0,
            'wallet' => 0,
        ]);
        $user = User::updateOrCreate(
            [
                'id' => Uuid::uuid4()->toString(),
                'first_name' => 'SuperAdmin',
                'surname' => "User",
                'role_id' => $superadmin->id,
                'email' => 'superadmin@medom.ng',
                'role' => $superadmin->name,
                'password' => bcrypt('password')
            ]
        );
        Profile::updateOrCreate([
            'id'=>Uuid::uuid4()->toString(),
            'user_id'=>$user->id,
            'bookings' => 0,
            'allergies' => 0,
            'wallet' => 0,
        ]);
        echo "Seeding Users Finished" . PHP_EOL;
    }
}
