<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ComicVineService
{
    private string $apiKey;
    private string $baseUrl = 'https://comicvine.gamespot.com/api';
    private string $cacert;

    // Publisher IDs en ComicVine
    const MARVEL_PUBLISHER_ID = 31;
    const DC_PUBLISHER_ID = 10;

    // Campos a pedir en listados (reduce tamaño de respuesta)
    const ISSUE_FIELDS = 'id,name,issue_number,volume,image,description,cover_date,store_date,site_detail_url,character_credits,person_credits';

    public function __construct()
    {
        $this->apiKey  = config('services.comicvine.api_key', '');
        $cacertPath    = storage_path('cacert.pem');
        $this->cacert  = file_exists($cacertPath) ? $cacertPath : true;
    }

    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    private function http(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withOptions(['verify' => $this->cacert])
            ->withHeaders(['User-Agent' => 'ComicBloom/1.0 (Laravel)'])
            ->timeout(15);
    }

    private function baseParams(array $extra = []): array
    {
        return array_merge([
            'api_key' => $this->apiKey,
            'format'  => 'json',
        ], $extra);
    }

    private function defaultImage(): string
    {
        return 'https://comicvine.gamespot.com/a/uploads/scale_avatar/6/67663/3504969-default.jpg';
    }

    private function hasImage(array $issue): bool
    {
        $url = $issue['image']['medium_url'] ?? $issue['image']['small_url'] ?? '';
        return !empty($url)
            && !str_contains($url, 'default')
            && !str_contains($url, 'blank')
            && str_starts_with($url, 'http');
    }

    private function normalize(array $issue): array
    {
        $title = '';
        if (!empty($issue['volume']['name'])) {
            $title = $issue['volume']['name'];
        }
        if (!empty($issue['issue_number'])) {
            $title .= ' #' . $issue['issue_number'];
        }
        if (!empty($issue['name'])) {
            $title .= ': ' . $issue['name'];
        }
        $title = trim($title) ?: 'Sin título';

        $thumbnailUrl = $issue['image']['medium_url']
            ?? $issue['image']['small_url']
            ?? $issue['image']['thumb_url']
            ?? $this->defaultImage();

        $characters = array_map(
            fn($c) => ['name' => $c['name']],
            array_slice($issue['character_credits'] ?? [], 0, 8)
        );

        $creators = array_map(
            fn($p) => ['name' => $p['name'], 'role' => $p['role'] ?? ''],
            array_slice($issue['person_credits'] ?? [], 0, 6)
        );

        $date = $issue['cover_date'] ?? $issue['store_date'] ?? null;

        return [
            'id'            => $issue['id'],
            'title'         => $title,
            'description'   => isset($issue['description']) ? strip_tags($issue['description']) : null,
            'thumbnail_url' => $thumbnailUrl,
            'large_url'     => $issue['image']['super_url'] ?? $issue['image']['original_url'] ?? $thumbnailUrl,
            'page_count'    => null,
            'cover_date'    => $date,
            'issue_number'  => $issue['issue_number'] ?? null,
            'volume_name'   => $issue['volume']['name'] ?? null,
            'site_url'      => $issue['site_detail_url'] ?? null,
            'characters'    => $characters,
            'creators'      => $creators,
        ];
    }

    public function getIssues(int $limit = 12, int $offset = 0): array
    {
        if (!$this->isConfigured()) {
            return ['comics' => [], 'total' => 0, 'error' => 'no_key'];
        }

        return Cache::remember("cv_issues_{$limit}_{$offset}", 3600, function () use ($limit, $offset) {
            $response = $this->http()->get("{$this->baseUrl}/issues/", $this->baseParams([
                'filter'     => 'publisher:' . self::MARVEL_PUBLISHER_ID,
                'sort'       => 'cover_date:desc',
                'limit'      => $limit,
                'offset'     => $offset,
                'field_list' => self::ISSUE_FIELDS,
            ]));

            if (!$response->successful()) {
                return ['comics' => [], 'total' => 0, 'error' => true];
            }

            $body   = $response->json();
            $results = $body['results'] ?? [];
            $comics  = collect($results)
                ->filter(fn($i) => $this->hasImage($i))
                ->map(fn($i) => $this->normalize($i))
                ->values()
                ->all();

            return ['comics' => $comics, 'total' => $body['number_of_total_results'] ?? 0, 'error' => false];
        });
    }

    public function searchIssues(string $query, int $limit = 12, int $offset = 0): array
    {
        if (!$this->isConfigured()) {
            return ['comics' => [], 'total' => 0, 'error' => 'no_key'];
        }

        $cacheKey = 'cv_search_' . md5($query) . "_{$limit}_{$offset}";

        return Cache::remember($cacheKey, 1800, function () use ($query, $limit, $offset) {
            $response = $this->http()->get("{$this->baseUrl}/search/", $this->baseParams([
                'query'      => $query,
                'resources'  => 'issue',
                'limit'      => $limit,
                'page'       => (int) ($offset / $limit) + 1,
                'field_list' => self::ISSUE_FIELDS,
            ]));

            if (!$response->successful()) {
                return ['comics' => [], 'total' => 0, 'error' => true];
            }

            $body   = $response->json();
            $results = $body['results'] ?? [];
            $comics  = collect($results)
                ->filter(fn($i) => $this->hasImage($i))
                ->map(fn($i) => $this->normalize($i))
                ->values()
                ->all();

            return ['comics' => $comics, 'total' => $body['number_of_total_results'] ?? 0, 'error' => false];
        });
    }

    public function getIssue(int $id): ?array
    {
        if (!$this->isConfigured()) {
            return null;
        }

        return Cache::remember("cv_issue_{$id}", 86400, function () use ($id) {
            $response = $this->http()->get("{$this->baseUrl}/issue/4000-{$id}/", $this->baseParams([
                'field_list' => 'id,name,issue_number,volume,image,description,cover_date,store_date,site_detail_url,character_credits,person_credits',
            ]));

            if (!$response->successful()) {
                return null;
            }

            $issue = $response->json()['results'] ?? null;
            return $issue ? $this->normalize($issue) : null;
        });
    }
}
