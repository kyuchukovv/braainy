<?php

namespace App\Services\Billy\Resources;

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
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function all()
    {
        $response = self::$resource->get('/contacts', '');
        $meta = $response['meta'];

        // If there are more pages
        if ($meta['paging'] && isset($meta['nextUrl'])) {
            // Start from the 2nd page, we already query the 1st
            for ($i = 2; $i <= $meta['pageCount']; $i++) {
                try {
                    $nextPage = self::$resource->get('/contacts', "page={$i}&pageSize={$meta['pageSize']}");
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                    continue;
                }
                if (!$nextPage['success'] || $nextPage['statusCode'] != 200) {
                    continue;
                }
                array_merge($response['contacts'], $nextPage['contacts']);
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
        $newContact = self::$resource->post('/contacts', [
            'contact' => $data
        ]);

        return $newContact;
    }

    /**
     * @param string $id contact_id
     * @param array $data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function update(string $id, array $data)
    {
        $updatedContact = self::$resource->update("/contacts/{$id}", [
            'contact' => $data
        ]);

        return $updatedContact;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function delete(string $id)
    {
        $deletedContact = self::$resource->delete("/contacts/{$id}");

        return $deletedContact;

    }

}
