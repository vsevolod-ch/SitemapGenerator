<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 13:37
 */

namespace SitemapGenerator\Sitemap\SitemapIndex;


use SitemapGenerator\Abstraction\AbstractXmlNode;

class SitemapNode extends AbstractXmlNode
{

    /**
     * Return tag name.
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'sitemap';
    }
}