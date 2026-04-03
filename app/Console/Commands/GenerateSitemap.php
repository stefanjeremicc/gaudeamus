<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\JobListing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate XML sitemap';

    public function handle(): void
    {
        $locales = ['sr', 'en', 'ru'];
        $baseUrl = config('app.url');

        $urls = [];

        // Static pages
        $staticPages = ['', '/poslovi', '/o-nama', '/kontakt', '/za-poslodavce', '/blog'];
        foreach ($staticPages as $page) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => $baseUrl . '/' . $locale . $page,
                    'changefreq' => $page === '/poslovi' ? 'daily' : 'weekly',
                    'priority' => $page === '' ? '1.0' : '0.8',
                    'alternates' => array_map(fn($l) => ['hreflang' => $l, 'href' => $baseUrl . '/' . $l . $page], $locales),
                ];
            }
        }

        // Job listings
        $jobs = JobListing::active()->get();
        foreach ($jobs as $job) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => $baseUrl . '/' . $locale . '/poslovi/' . $job->slug,
                    'lastmod' => $job->updated_at->toW3cString(),
                    'changefreq' => 'daily',
                    'priority' => '0.9',
                    'alternates' => array_map(fn($l) => ['hreflang' => $l, 'href' => $baseUrl . '/' . $l . '/poslovi/' . $job->slug], $locales),
                ];
            }
        }

        // Blog posts
        $posts = BlogPost::published()->get();
        foreach ($posts as $post) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => $baseUrl . '/' . $locale . '/blog/' . $post->slug,
                    'lastmod' => $post->updated_at->toW3cString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                    'alternates' => array_map(fn($l) => ['hreflang' => $l, 'href' => $baseUrl . '/' . $l . '/blog/' . $post->slug], $locales),
                ];
            }
        }

        // Build XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url['loc']}</loc>\n";
            if (isset($url['lastmod'])) {
                $xml .= "    <lastmod>{$url['lastmod']}</lastmod>\n";
            }
            $xml .= "    <changefreq>{$url['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$url['priority']}</priority>\n";
            foreach ($url['alternates'] as $alt) {
                $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"{$alt['hreflang']}\" href=\"{$alt['href']}\"/>\n";
            }
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        File::put(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap generated with ' . count($urls) . ' URLs.');
    }
}
