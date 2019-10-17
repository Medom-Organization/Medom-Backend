<?php

use Illuminate\Database\Seeder;
use Medom\Modules\Hospitals\Models\Settingshospital;
use Ramsey\Uuid\Uuid;

class HospitalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Seeding Hospitals Started" . PHP_EOL;
        Settingshospital::updateOrCreate(
            ['hid' => Uuid::uuid4()->toString(), 'hospitalname' => 'University Of Uyo Teaching Hospital']
        );

        Settingshospital::updateOrCreate(
            ['hid' => Uuid::uuid4()->toString(), 'hospitalname' => 'Lagos University Teaching Hospital']
        );
        Settingshospital::updateOrCreate(
            ['hid' => Uuid::uuid4()->toString(), 'hospitalname' => "St.Luke's Hospital, Anua Uyo"]
        );
        Settingshospital::updateOrCreate(
            ['hid' => Uuid::uuid4()->toString(), 'hospitalname' => 'General Hospital, Itu']
        );
        Settingshospital::updateOrCreate(
            ['hid' => Uuid::uuid4()->toString(), 'hospitalname' => 'Medom Hospital']
        );
        echo "Seeding Hospitals Finished" . PHP_EOL;
    }
    }