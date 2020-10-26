<?php

namespace App\Services\Billy\Resources;

use App\Services\Billy\BillyClient;
use Illuminate\Support\Facades\Log;

/**
 * Class Contact
 */
class Product extends Resource
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function all()
    {

        $products = self::$resource->get('/products', 'page=1&pageSize=20');
        \Illuminate\Support\Facades\Log::info($products['status']);
        \Illuminate\Support\Facades\Log::info($products);
        return $products;

    }

    /**
     * @param $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function create($data)
    {
        $newProduct = self::$resource->post('/products', [
            'product' => $data
        ]);

        return $newProduct['response'];
    }

}
