<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MarvelApiService
{
    private string $publicKey;
    private string $privateKey;
    private string $baseUrl;

    private string $cacert;

    public function __construct()
    {
        $this->publicKey  = config('services.marvel.public_key');
        $this->privateKey = config('services.marvel.private_key');
        $this->baseUrl    = config('services.marvel.base_url', 'https://gateway.marvel.com/v1/public');
        $cacertPath       = storage_path('cacert.pem');
        $this->cacert     = file_exists($cacertPath) ? $cacertPath : true;
    }

    private function http(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withOptions(['verify' => $this->cacert]);
    }

    private function auth(): array
    {
        $ts = time();
        return [
            'apikey' => $this->publicKey,
            'ts'     => $ts,
            'hash'   => md5($ts . $this->privateKey . $this->publicKey),
        ];
    }

    private function hasImage(array $comic): bool
    {
        $url = $comic['thumbnail']['path'] . '/portrait_uncanny.' . $comic['thumbnail']['extension'];
        return $url !== 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available/portrait_uncanny.jpg';
    }

    public function getComics(int $limit = 12, int $offset = 0): array
    {
        return Cache::remember("comics_list_{$limit}_{$offset}", 3600, function () use ($limit, $offset) {
            $response = $this->http()->get("{$this->baseUrl}/comics", array_merge($this->auth(), [
                'limit'  => $limit,
                'offset' => $offset,
                'orderBy' => 'title',
            ]));

            if (!$response->successful()) {
                return ['comics' => [], 'total' => 0, 'error' => true];
            }

            $data = $response->json()['data'];
            $comics = collect($data['results'])->filter(fn($c) => $this->hasImage($c))->values()->all();

            return ['comics' => $comics, 'total' => $data['total'], 'error' => false];
        });
    }

    public function searchComics(string $query, int $limit = 12, int $offset = 0): array
    {
        $cacheKey = "comics_search_" . md5($query) . "_{$limit}_{$offset}";

        return Cache::remember($cacheKey, 1800, function () use ($query, $limit, $offset) {
            $response = $this->http()->get("{$this->baseUrl}/comics", array_merge($this->auth(), [
                'limit'           => $limit,
                'offset'          => $offset,
                'titleStartsWith' => $query,
            ]));

            if (!$response->successful()) {
                return ['comics' => [], 'total' => 0, 'error' => true];
            }

            $data = $response->json()['data'];
            $comics = collect($data['results'])->filter(fn($c) => $this->hasImage($c))->values()->all();

            return ['comics' => $comics, 'total' => $data['total'], 'error' => false];
        });
    }

    public function getComic(int $id): ?array
    {
        return Cache::remember("comic_{$id}", 86400, function () use ($id) {
            $response = $this->http()->get("{$this->baseUrl}/comics/{$id}", $this->auth());

            if (!$response->successful()) {
                return null;
            }

            return $response->json()['data']['results'][0] ?? null;
        });
    }

    public function getCharacters(int $limit = 20, int $offset = 0): array
    {
        return Cache::remember("characters_{$limit}_{$offset}", 3600, function () use ($limit, $offset) {
            $response = $this->http()->get("{$this->baseUrl}/characters", array_merge($this->auth(), [
                'limit'   => $limit,
                'offset'  => $offset,
                'orderBy' => 'title',
            ]));

            if (!$response->successful()) {
                return [];
            }

            return $response->json()['data']['results'] ?? [];
        });
    }

    public function getComicsByCharacter(int $characterId, int $limit = 8): array
    {
        return Cache::remember("comics_character_{$characterId}_{$limit}", 3600, function () use ($characterId, $limit) {
            $response = $this->http()->get("{$this->baseUrl}/characters/{$characterId}/comics", array_merge($this->auth(), [
                'limit' => $limit,
            ]));

            if (!$response->successful()) {
                return [];
            }

            $results = $response->json()['data']['results'] ?? [];
            return collect($results)->filter(fn($c) => $this->hasImage($c))->values()->all();
        });
    }

    public function thumbnailUrl(array $comic, string $variant = 'portrait_uncanny'): string
    {
        return $comic['thumbnail']['path'] . '/' . $variant . '.' . $comic['thumbnail']['extension'];
    }
}
