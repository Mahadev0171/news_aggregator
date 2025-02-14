<?php

namespace App\Providers;
// use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Article;

class ArticleFetcheServiceProvider
{
    protected $newsApiKey = "b9bbecdee3cc49f0bcf470122f1e3fdb";
    protected $nytimesApiKey = "TKzgssgkB2kmzATJgSGF3vIPAWVKfjT5";
    protected $guardianApiKey = "c45e6b08-a4be-47ed-8c92-893a1a094e4b";

    // public function __construct()
    // {
    //     $this->client = new Client();
    //     $this->newsApiKey = env('NEWSAPI_KEY');
    //     $this->$nytimesApiKey = env('NYTIMES_API_KEY');
    //     $this->$guardianApiKey = env('GUARDIAN_API_KEY');
    // }

    public function fetchArticles()
    {
        $this->fetchFromNewsAPI();
        $this->fetchFromNYT();
        $this->fetchFromGuardian();
    }

    protected function fetchFromNewsAPI()
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'apiKey' => $this->newsApiKey,
            'country' => 'us',  // specify country code or any query params
        ]);

        $articles = $response->json()['articles'];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['url' => $article['url']],
                [
                    'source' => 'NewsAPI',
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'url' => $article['url'],
                    'url_to_image' => $article['urlToImage'],
                    'content' => $article['content'],
                    'published_at' => $article['publishedAt'],
                ]
            );
        }
    }

    protected function fetchFromNYT()
    {
        $response = Http::get('https://api.nytimes.com/svc/search/v2/articlesearch.json?q=sports', [
            'api-key' => $this->nytimesApiKey,
        ]);

        $responseData = $response->json();

        if (array_key_exists('results', $responseData)) {
            $articles = $response->json()['results'];

            foreach ($articles as $article) {
                Article::updateOrCreate(
                    ['url' => $article['url']],
                    [
                        'source' => 'New York Times',
                        'title' => $article['title'],
                        'description' => $article['abstract'],
                        'url' => $article['url'],
                        'url_to_image' => $article['multimedia'][0]['url'] ?? null,
                        'content' => null, 
                        'published_at' => $article['published_date'],
                    ]
                );
            }
        }
        // while ($response->json()['results']) {
        //     $articles = $response->json()['results'];

        //     foreach ($articles as $article) {
        //         Article::updateOrCreate(
        //             ['url' => $article['url']],
        //             [
        //                 'source' => 'New York Times',
        //                 'title' => $article['title'],
        //                 'description' => $article['abstract'],
        //                 'url' => $article['url'],
        //                 'url_to_image' => $article['multimedia'][0]['url'] ?? null,
        //                 'content' => null, 
        //                 'published_at' => $article['published_date'],
        //             ]
        //         );
        //     }
        // }

    }

    protected function fetchFromGuardian()
    {
        $response = Http::get('https://content.guardianapis.com/search', [
            'api-key' => $this->guardianApiKey,
            'section' => 'world',  // specify section or use any filters
        ]);

        $articles = $response->json()['response']['results'];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['url' => $article['webUrl']],
                [
                    'source' => 'The Guardian',
                    'title' => $article['webTitle'],
                    'description' => $article['trailText'] ?? null,
                    'url' => $article['webUrl'],
                    'url_to_image' => $article['thumbnail'] ?? null,
                    'content' => null, 
                    'published_at' => $article['webPublicationDate'],
                ]
            );
        }
    }
}
