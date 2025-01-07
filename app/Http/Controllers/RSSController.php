<?php

namespace App\Http\Controllers;

use App\Services\GuardianAPIService;
use App\Services\RSSFeedGenerator;

class RSSController extends Controller
{
    public function generateRSS($section)
    {
        // Fetch articles
        $articles = (new GuardianAPIService())->getSectionArticles($section);

        // If no articles are found, return 404
        if (empty($articles)) {
            return response()->json(['error' => "No articles found for section: $section"], 404);
        }

        // Generate RSS feed
        $rssFeed = RSSFeedGenerator::create($articles, $section);

        // Return RSS feed as XML
        return response($rssFeed, 200)->header('Content-Type', 'application/rss+xml');
    }
}
