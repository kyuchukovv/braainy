<?php

namespace App\Services\Billy\Resources;

use App\Services\Billy\BillyClient;
use Illuminate\Support\Facades\Log;

/**
 * Class Contact
 */
class Contact extends Resource
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return BillyClient
     */
    public static function getBillyClient()
    {
        return self::$resource;
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function all()
    {

        $contacts = self::$resource->get('/contacts', 'page=1&pageSize=20');
        \Illuminate\Support\Facades\Log::info($contacts['status']);
        \Illuminate\Support\Facades\Log::info($contacts);
        return $contacts;

    }

    /**
     * @param $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function create($data)
    {
        $newContact = self::$resource->post('/contacts', ['product']);

        return $newContact;
    }

}
