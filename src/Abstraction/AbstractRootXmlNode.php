<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 16:00
 */

namespace SitemapGenerator\Abstraction;


use SitemapGenerator\Interfaces\XmlNode;
use SitemapGenerator\Interfaces\XmlRootNode;

abstract class AbstractRootXmlNode implements XmlRootNode
{
    /**
     * @var XmlNode[]
     */
    protected $container = [];
    /**
     * @var string
     */
    protected static $namespace = "http://www.sitemaps.org/schemas/sitemap/0.9";

    /**
     * Return element.
     *
     * @param \DOMNode $node
     */
    public function save(\DOMNode $node): void
    {
        $element = new \DOMElement(static::getName(), null, static::$namespace);
        $node->appendChild($element);
        $this->appendChilds($element);
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return count($this->container);
    }

    /**
     * Create new node.
     *
     * @param string $loc
     * @param string|null $lastMod
     * @return XmlNode
     */
    public function add(string $loc, string $lastMod = null): XmlNode
    {
        $xmlNode = static::getXmlNode($loc, $lastMod);
        $this->container[] = $xmlNode;
        return $xmlNode;
    }

    /**
     * @param \DOMElement $el
     */
    protected function appendChilds(\DOMElement $el): void
    {
        if (count($this->container) === 0)
            return;
        foreach ($this->container as $node) {
            $node->save($el);
        }
    }
}