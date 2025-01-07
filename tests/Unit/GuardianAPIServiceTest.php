<?php

namespace Tests\Unit;

use App\Services\GuardianAPIService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GuardianAPIServiceTest extends TestCase
{
    public function testGuardianAPIServiceFetchesArticles()
    {
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

        $service = new GuardianAPIService();


        $articles = $service->getSectionArticles('technology');

        $this->assertNotEmpty($articles);

        $this->assertCount(2, $articles);
        
        $this->assertEquals('Test Article 1', $articles[0]['webTitle']);
    }
}
