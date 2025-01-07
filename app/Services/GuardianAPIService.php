<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GuardianAPIService
{
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        // Fetch API key and url from environment variable
        $this->apiKey = env('GUARDIAN_API_KEY');
        $this->apiUrl = env('GUARDIAN_API_URL');
    }

    public function getSectionArticles(string $section): array
    {
        // Cache api response for 10 minutes
        return Cache::remember("section-{$section}", 600, function () use ($section) {
            $response = Http::get("{$this->apiUrl}/{$section}", [
                'api-key' => $this->apiKey,
                'format' => 'json',
                'show-fields' => 'trailText,webTitle,webUrl',
            ]);

            //check response fail or missing result
            if ($response->failed() || !isset($response->json()['response']['results'])) {
                return [];
            }

            return $response->json()['response']['results'];
        });
    }
}
