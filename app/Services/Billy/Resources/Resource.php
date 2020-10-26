<?php
namespace App\Services\Billy\Resources;


use App\Services\Billy\BillyClient;

/**
 * Class Resource
 */
class Resource
{
    /**
     * @var BillyClient
     */
    public static $resource;

    /**
     * Resource constructor.
     */
    public function __construct()
    {
        self::$resource = new BillyClient();
    }

}
