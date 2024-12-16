<?php

namespace NFService\Services;

use NFService\Client\HttpClient;
use NFService\Fugzap;

class Messages
{
    protected HttpClient $client;

    public function __construct(Fugzap $fugzap)
    {
        $this->client = $fugzap->getClient();
    }

    /**
     * @param string $number
     * @param string $message
     * @return array
     * @throws \Exception
     */
    public function sendMessage(string $number, string $message, array $params = [])
    {
        $body = array_merge($params, [
            'number' => $number,
            'body' => $message,
        ]);

        return $this->client->requisicao('/messages/send', 'POST', $body);
    }

    /**
     * @param string $number
     * @param string $mediaPath
     * @return array
     * @throws \Exception
     */
    public function sendMediaMessage(string $number, string $mediaPath, array $params = [])
    {
        $body = array_merge($params, [
            [
                'name' => 'number',
                'contents' => $number,
            ],
            [
                'name' => 'medias',
                'contents' => file_get_contents($mediaPath),
                'filename' => basename($mediaPath)
            ]
        ]);

        return $this->client->requisicao(
            '/messages/send',
             'POST',
             $body,
             null,
             'multipart'
        );
    }
}