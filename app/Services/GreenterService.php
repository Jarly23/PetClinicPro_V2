<?php

namespace App\Services;

use Greenter\See;
use Illuminate\Support\Facades\Config;

class GreenterService
{
    private $see;

    public function __construct()
    {
        $this->see = new See();
        $this->see->setCertificate(file_get_contents(config('greenter.certificate')));
        $this->see->setService(config('greenter.endpoint'));
        $this->see->setClaveSOL(
            config('greenter.ruc'),
            config('greenter.user_sol'),
            config('greenter.password_sol')
        );
    }

    public function getSee()
    {
        return $this->see;
    }
}