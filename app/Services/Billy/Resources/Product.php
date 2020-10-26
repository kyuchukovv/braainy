<?php

namespace App\Services\Billy\Resources;


use Illuminate\Support\Facades\Log;

/**
 * Class Product
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
        $response = self::$resource->get('/products', '');
        $meta = $response['meta'];

        // If there are more pages
        if ($meta['paging'] && isset($meta['nextUrl'])) {
            // Start from the 2nd page, we already query the 1st
            for ($i = 2; $i <= $meta['pageCount']; $i++) {
                try {
                    $nextPage = self::$resource->get('/products', "page={$i}&pageSize={$meta['pageSize']}");
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                    continue;
                }
                if (!$nextPage['success'] || $nextPage['statusCode'] != 200) {
                    continue;
                }
                array_merge($response['products'], $nextPage['products']);
            }
        }

        return $response;
    }

    /**
     * @param array $data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function create(array $data)
    {
        $newProduct = self::$resource->post('/products', [
            'product' => $data
        ]);

        return $newProduct;
    }

    /**
     * @param string $id product_id
     * @param array $data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function update(string $id, array $data)
    {
        $updatedProduct = self::$resource->update("/products/{$id}", [
            'product' => $data
        ]);

        return $updatedProduct;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function delete(string $id)
    {
        $deletedProduct = self::$resource->delete("/products/{$id}");

        return $deletedProduct;

    }

}
