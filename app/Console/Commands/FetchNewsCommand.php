<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Providers\ArticleFetcheServiceProvider;

class FetchNewsCommand extends Command
{
    protected $signature = 'fetch:articles';
    protected $description = 'Fetch and store articles from various sources';

    protected $articleFetcher;

    public function __construct(ArticleFetcheServiceProvider $articleFetcher)
    {
        parent::__construct();
        $this->articleFetcher = $articleFetcher;
    }

    public function handle()
    {
        $this->articleFetcher->fetchArticles();
        $this->info('Articles fetched and stored successfully.');
    }
}



// use App\Providers\NewsApiServiceProvider;
// use App\Models\Article;

// class FetchNewsCommand extends Command
// {
//     protected $signature = 'news:fetch';
//     protected $description = 'Fetch articles from multiple news APIs';

//     protected $NewsApiServiceProvider;

//     public function __construct(NewsApiServiceProvider $NewsApiServiceProvider)
//     {
//         parent::__construct();
//         $this->NewsApiServiceProvider = $NewsApiServiceProvider;
//     }

//     public function handle()
//     {
//         $articles = $this->NewsApiServiceProvider->fetchArticles();
        
//         foreach ($articles as $articleData) {
//             Article::updateOrCreate(
//                 ['source_id' => $articleData['source']['id'], 'title' => $articleData['title']],
//                 [
//                     'author' => $articleData['author'],
//                     'content' => $articleData['content'],
//                     'published_at' => $articleData['publishedAt'],
//                     'url' => $articleData['url'],
//                     'source_name' => $articleData['source']['name'],
//                     'image' => $articleData['urlToImage'],
//                 ]
//             );
//         }
//     }
// }
