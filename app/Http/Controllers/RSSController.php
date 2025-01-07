<?php

namespace App\Http\Controllers;

use App\Services\GuardianAPIService;
use App\Services\RSSFeedGenerator;

class RSSController extends Controller
{
    public function generateRSS($section)
    {
        // Validation section
        if (!preg_match('/^[a-z-]+$/', $section)) {
            return response()->json(['error' => 'Invalid section name'], 400);
        }

        // Articles to fetch
        $articles = (new GuardianAPIService())->getSectionArticles($section);

        // Condition if article not found returns response with 404
        if (empty($articles)) {
            return response()->json(['error' => "No articles found for section: $section"], 404);
        }

        // Generate rss feed
        $rssFeed = RSSFeedGenerator::create($articles, $section);

        // Return rss as xml
        return response($rssFeed, 200)->header('Content-Type', 'application/rss+xml');
    }
}
