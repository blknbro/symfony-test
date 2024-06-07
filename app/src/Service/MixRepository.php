<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixRepository
{



    public function __construct(
        private CacheInterface $cache,
        private HttpClientInterface $githubContentClient,
        #[Autowire('%kernel.debug%')]
        private bool $isDebug,
        #[Autowire(service: 'twig.command.debug')]
        private DebugCommand $twigDebugCommand
    )
    {
    }

    public function findAll(): array
    {

        return $this->cache->get('GET', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter($this->isDebug ? 5 : 60 );
            $respone = $this->githubContentClient->request('GET', 'SymfonyCasts/vinyl-mixes/main/mixes.json');
            return $respone->toArray();
        });
    }


}