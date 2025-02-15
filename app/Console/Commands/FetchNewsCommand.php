<?php

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

