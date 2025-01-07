<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\GuardianAPIService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GuardianAPIServiceTest extends TestCase
{
    public function testGuardianAPIServiceFetchesArticles()
    {
        // Fake the HTTP response
        Http::fake([
            'https://content.guardianapis.com/technology*' => Http::response([
                'response' => [
                    'results' => [
                        ['webTitle' => 'Test Article 1', 'webUrl' => 'https://example.com/1'],
                        ['webTitle' => 'Test Article 2', 'webUrl' => 'https://example.com/2'],
                    ]
                ]
            ], 200),
        ]);

        // Instantiate the service and fetch articles
        $service = new GuardianAPIService();
        $articles = $service->getSectionArticles('technology');

        // Assertions
        $this->assertNotEmpty($articles);
        $this->assertCount(2, $articles);
        $this->assertEquals('Test Article 1', $articles[0]['webTitle']);
    }
}
