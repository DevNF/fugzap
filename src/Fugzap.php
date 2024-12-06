<?php

namespace NFService;

use Exception;
use NFService\Client\HttpClient;
use NFService\Options\EnvironmentUrls;
use NFService\Services\Messages;

class Fugzap
{
    protected string $base_url;
    protected string $token;
    protected HttpClient $client;

    public function __construct(
        string $token,
        ?bool $debug = false
    ) {
        if (empty($token)) {
            throw new Exception('Token é obrigatório');
        }

        $this->base_url = EnvironmentUrls::production_url;
        $this->token = $token;
        $this->client = new HttpClient($this, $debug);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getBaseUrl(): string
    {
        return $this->base_url;
    }

    public function getClient(): HttpClient
    {
        return $this->client;
    }

    public function messages(): Messages
    {
        return new Messages($this);
    }
}