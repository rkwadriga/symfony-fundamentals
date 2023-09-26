<?php declare(strict_types=1);
/**
 * Created 2023-09-26 09:19:02
 * Author rkwadriga
 */

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MixRepository
{
    private const MIXES_URL = '/SymfonyCasts/vinyl-mixes/main/mixes.json';

    public function __construct(
        private readonly HttpClientInterface $githubContentClient,
        private readonly CacheInterface $cache,
        #[Autowire('%cache.lifetime%')]
        private readonly int $lifetime
    ) {
    }

    public function findAll(): array
    {
        return $this->cache->get('mixes.github', function(CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter($this->lifetime);

            return $this->githubContentClient->request(Request::METHOD_GET, self::MIXES_URL)->toArray();
        });
    }
}