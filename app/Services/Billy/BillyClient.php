<?php


namespace App\Services\Billy;

use App\Services\Service;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;

/**
 * Class BillyClient
 * @package App\Services
 */
class BillyClient extends Service
{
    /**
     * @var string
     */
    private $endpointUrl = 'https://api.billysbilling.com/';
    /**
     * @var string
     */
    private $apiVersion = 'v2';
    /**
     * @var Client
     */
    private $client;

    /**
     * Initialize HTTP client(guzzle) config
     * @return Client
     */
    private function http()
    {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => $this->endpointUrl,
                'headers' => [
                    'X-Access-Token' => config('services.billy.access_token'),
                    'Content-Type' => 'application/json'
                ]
            ]);
        }

        return $this->client;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param $payload
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request($method, $uri, $payload)
    {
        $url = $this->apiVersion . $uri;

        try {
            $response = $this->http()
                ->request($method, $url, [RequestOptions::JSON => $payload]);
            $status = 'success';
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $status = 'error';
        }

        $response = json_decode($response->getBody()->getContents(), true);

        return compact('status', 'response');
    }

    /**
     * @param string $uri
     * @param string $payload
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($uri, $payload)
    {
        return $this->request('GET', $uri, [
            'query' => $payload
        ]);
    }

    /**
     * @param $uri
     * @param $payload
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($uri, $payload)
    {
        return $this->request('POST', $uri, $payload);
    }

    /**
     * @param $uri
     * @param $payload
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($uri, $payload)
    {
        return $this->request('DELETE', $uri, $payload);
    }

    /**
     * @param $uri
     * @param $payload
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($uri, $payload)
    {
        return $this->request('PUT', $uri, $payload);

    }


}
