<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RSSControllerTest extends TestCase
{
    public function testValidSectionReturnsRSSFeed()
    {
        // Fake the Guardian API response
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

        // Make a GET request to the endpoint
        $response = $this->get('/technology');

        // Assertions
        $response->assertStatus(200)
                ->assertHeader('Content-Type', 'application/rss+xml');

        // Decode response content and check for the title
        $responseContent = htmlspecialchars_decode($response->getContent());
        $this->assertStringContainsString('<title>Test Article</title>', $responseContent);
    }


    public function testInvalidSectionReturns404()
    {
        // Make a GET request to an invalid section
        $response = $this->get('/invalid-section');

        // Assertions
        $response->assertStatus(404);
        $response->assertJson(['error' => 'No articles found for section: invalid-section']);
    }
}
