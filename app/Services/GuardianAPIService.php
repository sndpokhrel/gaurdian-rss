<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GuardianAPIService
{
    private $apiKey = '8d0d9d2c-47fe-4703-88ab-9296a489a412';

    public function getSectionArticles(string $section): array
    {
        $response = Http::get("https://content.guardianapis.com/{$section}", [
            'api-key' => $this->apiKey,
            'format' => 'json',
            'show-fields' => 'trailText,webTitle,webUrl',
        ]);

        if ($response->failed() || !isset($response->json()['response']['results'])) {
            return [];
        }

        return Cache::remember("section-{$section}", 600, function () use ($section) {
            $response = Http::get("https://content.guardianapis.com/{$section}", [
                'api-key' => $this->apiKey,
                'format' => 'json',
                'show-fields' => 'trailText,webTitle,webUrl',
            ]);

            return $response->failed() ? [] : $response->json()['response']['results'] ?? [];
        });
    }

}
