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
            ['hid' => '40201ce1-ad91-4a71-81d1-dd600de03c0a', 'hospitalname' => 'University Of Uyo Teaching Hospital']
        );
        echo "Seeded University Of Uyo Teaching Hospital" . PHP_EOL;

        Settingshospital::updateOrCreate(
            ['hid' => 'd6b832ce-b4c1-4cbc-8b69-026bc058624c', 'hospitalname' => 'Lagos University Teaching Hospital']
        );
        Settingshospital::updateOrCreate(
            ['hid' => 'd6b832ce-b4c1-4cbc-8b69-026bc058624c', 'hospitalname' => "St.Luke's Hospital, Anua Uyo"]
        );
        Settingshospital::updateOrCreate(
            ['hid' => '9b24f140-ac65-44e2-a602-d01a46030e3c', 'hospitalname' => 'General Hospital, Itu']
        );
        Settingshospital::updateOrCreate(
            ['hid' => '33325d4c-bd21-4429-9c51-88658dd546c7', 'hospitalname' => 'Medom Hospital']
        );
        echo "Seeding Hospitals Finished" . PHP_EOL;
    }
}
