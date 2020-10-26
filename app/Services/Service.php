<?php

namespace App\Services;



use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Service
 * @package App\Services
 */
abstract class Service
{
    abstract function get($uri, $payload);
}
