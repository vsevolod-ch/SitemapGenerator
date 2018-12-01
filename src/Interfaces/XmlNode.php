<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 13:48
 */

namespace SitemapGenerator\Interfaces;


use Ds\Map;

interface XmlNode extends Xml
{
    public function setLoc(string $loc): void;
    public function setLastMod(string $lastMod = null): void;
    public function setAttributes(Map $attr): void;
}