<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 13:30
 */

namespace SitemapGenerator\Sitemap\SitemapIndex;


use SitemapGenerator\Abstraction\AbstractRootXmlNode;
use SitemapGenerator\Interfaces\XmlNode;

class SitemapIndexNode extends AbstractRootXmlNode
{
    /**
     * @var SitemapNode[]
     */
    protected $container = [];

    /**
     * @param string $loc
     * @param string|null $lastMod
     * @return XmlNode
     */
    public static function getXmlNode(string $loc, string $lastMod = null): XmlNode
    {
        return new SitemapNode($loc, $lastMod);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'sitemapindex';
    }
}