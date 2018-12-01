<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 02.12.18
 * Time: 0:58
 */

require __DIR__.'/../vendor/autoload.php';

$sitemap = new \SitemapGenerator\Sitemap(__DIR__ . '/sitemap.xml', 'http://example.com/');

for ($i = 0; $i < 24000; $i++) {
    $sitemap->add('http://example.com/' . $i);
}

$sitemap->save();

