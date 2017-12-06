<?php

namespace App\Source;

use GuzzleHttp\Client as HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class Definition
{
    protected $client;
    protected $url;
    protected $crawler;

    public function __construct(Crawler $crawler, HttpClient $client)
    {
        $this->client = $client;
        $this->crawler = $crawler;
        $this->url = 'http://www.dictionary.com/browse/';
    }

    public function findDefinitions($word)
    {
        $page = $this->client->get($this->url . $word)->getBody()->getContents();

        $this->crawler->add($page);

        $definitions = [];

        $this->crawler->filter('div.def-list')->first()->filter('div.def-content')
            ->reduce(function (Crawler $node, $i) use (&$definitions) {
                $definitionOnly = explode(':', $node->text());
                $definitions[] = trim($definitionOnly[0]);
            });

        echo implode(PHP_EOL, array_unique(array_slice($definitions, 0, 3)));
    }
}