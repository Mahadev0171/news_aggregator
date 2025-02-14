<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class NewsApiServiceProvider extends ServiceProvider
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('NEWSAPI_KEY'); // Store API Key in .env
    }

    public function fetchArticles($page = 1)
    {
        $response = $this->client->get("https://newsapi.org/v2/top-headlines", [
            'query' => [
                'apiKey' => $this->apiKey,
                'page' => $page,
                'pageSize' => 20, // Number of articles per page
                'language' => 'en'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true)['articles'];
    }
}
