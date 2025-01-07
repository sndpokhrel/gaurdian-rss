<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RSSControllerTest extends TestCase
{
    public function testValidSectionReturnsRSSFeed()
    {
        Http::fake([
            'https://content.guardianapis.com/technology*' => Http::response([
                'response' => [
                    'results' => [
                        [
                            'webTitle' => 'Test Article',
                            'webUrl' => 'https://example.com',
                            'webPublicationDate' => '2025-01-07T12:00:00Z',
                        ],
                    ],
                ],
            ], 200),
        ]);
        $response = $this->get('/technology');


        $response->assertStatus(200)
                ->assertHeader('Content-Type', 'application/rss+xml');



        $responseContent = htmlspecialchars_decode($response->getContent());
        $this->assertStringContainsString('<title>Test Article</title>', $responseContent);
    }


    public function testInvalidSectionReturns404()
    {


        $response = $this->get('/invalid-section');
        
        $response->assertStatus(404);
        $response->assertJson(['error' => 'No articles found for section: invalid-section']);
    }
}
