<?php

namespace App\Source;

use GuzzleHttp\Client as HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class Synonym
{
    protected $client;
    protected $url;
    protected $crawler;

    public function __construct(Crawler $crawler, HttpClient $client)
    {
        $this->client = $client;
        $this->crawler = $crawler;
        $this->url = 'http://www.thesaurus.com/browse/';
    }

    public function findSynonyms($word)
    {
        $page = $this->client->get($this->url . $word)->getBody()->getContents();

        $this->crawler->add($page);

        $synonyms = [];

        $this->crawler->filter('div.relevancy-list')->first()->filter('ul:first-child > li > a > span.text')
            ->reduce(function (Crawler $node, $i) use (&$synonyms) {
                $synonyms[] = $node->text();
        });

        echo implode(', ', array_unique($synonyms));
    }
}