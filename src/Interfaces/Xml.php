<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 16:28
 */

namespace SitemapGenerator\Interfaces;


interface Xml
{
    public function save(\DOMNode $node): void;
    public static function getName(): string;
}