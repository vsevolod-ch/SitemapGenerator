<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 14:04
 */

namespace SitemapGenerator\Sitemap;


use Ds\Map;
use SitemapGenerator\Interfaces\XmlRootNode;
use SitemapGenerator\Sitemap\SitemapIndex\SitemapIndexNode;
use SitemapGenerator\Sitemap\UrlSet\UrlNode;
use SitemapGenerator\Sitemap\UrlSet\UrlSetNode;

class SitemapFile
{
    /**
     * @var XmlRootNode
     */
    protected $root;

    public function __construct(XmlRootNode $root)
    {
        $this->root = $root;
    }

    /**
     * Create and fill xml DOM object.
     *
     * @return \DOMDocument
     */
    public function save(): \DOMDocument
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $this->root->save($dom);
        return $dom;
    }

    /**
     * Get count of elements inside root.
     *
     * @return int
     */
    public function size(): int
    {
        return $this->root->size();
    }

    /**
     * Add new element.
     *
     * @param string $loc
     * @param string $lastMod
     * @param float|null $priority
     * @param string|null $changeFreq
     * @param Map|null $attr
     * @throws \SitemapGenerator\Exceptions\UnsupportedChangeFreqValueException
     */
    public function add(string $loc, string $lastMod = null, float $priority = null, string $changeFreq = null, Map $attr = null): void
    {
        $xmlNode = $this->root->add($loc, $lastMod);
        if ($attr)
            $xmlNode->setAttributes($attr);
        if ($xmlNode instanceof UrlNode) {
            if ($priority)
                $xmlNode->setPriority($priority);
            if ($changeFreq)
                $xmlNode->setChangeFreq($changeFreq);
        }
    }

    /**
     * Get a url sitemap object.
     *
     * @return SitemapFile
     */
    public static function getUrlSitemap(): SitemapFile
    {
        return new SitemapFile(new UrlSetNode());
    }

    /**
     * Get an index sitemap object.
     *
     * @return SitemapFile
     */
    public static function getIndexSitemap(): SitemapFile
    {
        return new SitemapFile(new SitemapIndexNode());
    }
}