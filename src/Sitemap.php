<?php
namespace SitemapGenerator;

use Ds\Map;
use SitemapGenerator\Exceptions\SitemapLoadFailureException;
use SitemapGenerator\Exceptions\WriteOpenFailureException;
use SitemapGenerator\Sitemap\SitemapFile;
use SitemapGenerator\Sitemap\SitemapIndex\SitemapIndexNode;
use SitemapGenerator\Sitemap\UrlSet\UrlSetNode;

class Sitemap
{

    const MAX_COUNT = 5000;
    /**
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $host;
    /**
     * @var SitemapFile[]
     */
    protected $siteMaps;

    /**
     * Sitemap constructor.
     *
     * @param string $path for example "/var/www/public/sitemap.xml"
     * @param string $host for example "http://google.com/"
     */
    public function __construct(string $path, string $host)
    {
        $this->path = $path;
        $this->host = $host;
        if (file_exists($path))
            $this->remove();
        $this->siteMaps[] = static::getUrlSitemap();
    }

    /**
     * Add url to a last sitemap object.
     *
     * @param string $loc
     * @param string|null $lastMod
     * @param float $priority
     * @param string $changeFreq
     * @param Map $attr
     */
    public function add(string $loc, string $lastMod = null, float $priority = null, string $changeFreq = null, Map $attr = null): void
    {
        $sitemap = end($this->siteMaps);
        if ($sitemap->size() < self::MAX_COUNT) {
            $sitemap->add($loc, $lastMod, $priority, $changeFreq, $attr);
            return;
        }
        $sitemap = static::getUrlSitemap();
        $sitemap->add($loc, $lastMod, $priority, $changeFreq, $attr);
        $this->siteMaps[] = $sitemap;
    }

    /**
     * Save sitemaps.
     */
    public function save(): void
    {
        if (count($this->siteMaps) == 1) {
            $this->writeSitemapFile($this->siteMaps[0], $this->path);
            return;
        }
        $dir = dirname($this->path);
        $baseName = basename($this->path, '.xml');
        $i = 1;
        $indexSitemap = static::getIndexSitemap();
        foreach ($this->siteMaps as $siteMap) {
            $name = sprintf('%s_%02d.xml', $baseName, $i++);
            $url = $this->host . $name;
            $path = $dir . '/' . $name;
            $this->writeSitemapFile($siteMap, $path);
            $indexSitemap->add($url);
        }
        $this->writeSitemapFile($indexSitemap, $this->path);
    }

    /**
     * Write sitemap to file.
     *
     * @param SitemapFile $sitemap
     * @param string $path
     * @throws WriteOpenFailureException
     */
    protected function writeSitemapFile(SitemapFile $sitemap, string $path): void
    {
        $f = fopen($path, 'wt');
        if ($f === false)
            throw new WriteOpenFailureException($path);
        fwrite($f, $sitemap->save()->saveXML());
        fclose($f);
    }

    /**
     * Remove old sitemaps.
     *
     * @throws SitemapLoadFailureException
     */
    protected function remove(): void
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        if (!$dom->load($this->path))
            throw new SitemapLoadFailureException($this->path);
        $sitemapIndex = $dom->getElementsByTagName('sitemapindex')->item(0);
        if ($sitemapIndex !== null) {
            $siteMaps = $dom->getElementsByTagName('loc');
            $dir = dirname($this->path);
            foreach ($siteMaps as $sm) {
                $file = basename($sm->nodeValue);
                $path = $dir . '/' . $file;
                if (file_exists($path))
                    unlink($path);
            }
        }
        unlink($this->path);
    }

    /**
     * Get a url sitemap object.
     *
     * @return SitemapFile
     */
    protected static function getUrlSitemap(): SitemapFile
    {
        return new SitemapFile(new UrlSetNode());
    }

    /**
     * Get an index sitemap object.
     *
     * @return SitemapFile
     */
    protected static function getIndexSitemap(): SitemapFile
    {
        return new SitemapFile(new SitemapIndexNode());
    }

}