<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 13:30
 */

namespace SitemapGenerator\Sitemap\UrlSet;


use SitemapGenerator\Abstraction\AbstractRootXmlNode;
use SitemapGenerator\Interfaces\XmlNode;

class UrlSetNode extends AbstractRootXmlNode
{
    /**
     * @var UrlNode[]
     */
    protected $container = [];

    /**
     * @param string $loc
     * @param string|null $lastMod
     * @return XmlNode
     */
    public static function getXmlNode(string $loc, string $lastMod = null): XmlNode
    {
        return new UrlNode($loc, $lastMod);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'urlset';
    }
}