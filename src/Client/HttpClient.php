<?php

namespace NFService\Client;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use NFService\Fugzap;
use NFService\Options\EnvironmentUrls;
use stdClass;


class HttpClient
{
    private bool $debug;
    private string $base_url;
    private Fugzap $fugzap;

    public function __construct(Fugzap $fugzap, bool $debug = false)
    {
        $this->fugzap = $fugzap;
        $this->base_url = EnvironmentUrls::production_url;
        $this->debug = $debug;
    }

    public function requisicao(string $uri, string $metodo, ?array $corpo = null, ?array $params = null, ?string $contentType = 'json'): string | GuzzleException | array | stdClass | null
    {
        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->request($metodo, $this->base_url . $uri, [
                'debug' => $this->debug,
                'http_errors' => false,
                'headers' => [ 'Authorization' => 'Bearer ' . $this->fugzap->getToken() ],
                'query' => $params,
                $contentType => $corpo
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e;
        }

    }
}
