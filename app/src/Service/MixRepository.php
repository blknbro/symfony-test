<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixRepository
{



    public function __construct(
        private CacheInterface $cache,
        private HttpClientInterface $httpClient
    )
    {
    }

    public function findAll(): array
    {
        return $this->cache->get('GET', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(5);
            $respone = $this->httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
            return $respone->toArray();
        });
    }


}