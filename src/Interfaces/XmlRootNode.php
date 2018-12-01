<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 14:28
 */

namespace SitemapGenerator\Interfaces;


interface XmlRootNode extends Xml
{
    public function size(): int;
    public function add(string $loc, string $lastMod = null): XmlNode;
    public static function getXmlNode(string $loc, string $lastMod = null): XmlNode;

}