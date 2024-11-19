<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;

class SitemapGenerate extends Command
{
    protected $signature = 'app:sitemap-generate';

    protected $description = 'Generate website sitemap.xml';

    public function handle()
    {
        $url = $this->ensureTrailingSlash(config('app.url'));
        $sitemapIndex = SitemapIndex::create();
        $limit = 40000;
        $chunk = 1;

        $sitemap = Sitemap::create();

        SitemapGenerator::create($url)
            ->hasCrawled(function ($url) use (&$sitemap, &$chunk, &$sitemapIndex, $limit) {
                $actualUrl = $url->url;

                if (strpos($actualUrl, '&page=') !== false || strpos($actualUrl, '?page=') !== false) {
                    return null;
                }

                $sitemap->add($url);

                if (count($sitemap->getTags()) >= $limit) {
                    $this->writeSitemapFile($sitemap, $chunk, $sitemapIndex);
                    $chunk++;
                    $sitemap = Sitemap::create();
                }

                return $url;
            })
            ->writeToFile(public_path("sitemap_{$chunk}.xml"));

        if (count($sitemap->getTags()) > 0) {
            $this->writeSitemapFile($sitemap, $chunk, $sitemapIndex);
        }

        $sitemapIndex->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully');
    }

    private function ensureTrailingSlash($url)
    {
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['path']) && !str_ends_with($parsedUrl['path'], '/')) {
            $url .= '/';
        }
        return $url;
    }

    private function writeSitemapFile($sitemap, $chunk, $sitemapIndex)
    {
        $filename = "sitemap_{$chunk}.xml";
        $sitemap->writeToFile(public_path($filename));
        $sitemapIndex->add(url($filename));
    }
}
