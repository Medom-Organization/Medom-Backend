<?php


namespace Medom\Modules;


use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class BaseRepository
{

    /**
     * Generates UuId
     * @return mixed
     * @throws \Exception
     */
    public function generateUuid()
    {
        return Uuid::uuid4()->toString();
    }



    public function slugIt($text)
    {
        return str_replace('--', '-', strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', trim($text))));
    }
}
