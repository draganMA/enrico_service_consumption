<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DataService {
    private $url;
    private $client;
    
    public function __construct(string $url, HttpClientInterface $client)
    {
        $this->url = $url;
        $this->client = $client;
    }

    public function getData(): array
    {
        $response = $this->client->request('GET', $this->url);
        $content = $response->toArray();
        return $content;
    }

}