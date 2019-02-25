<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 16:16
 */

namespace SitemapGenerator\Abstraction;


use Ds\Map;
use SitemapGenerator\Exceptions\AttributeNameIsNotStringException;
use SitemapGenerator\Exceptions\AttributeValueIsNotScalarException;
use SitemapGenerator\Interfaces\XmlNode;

abstract class AbstractXmlNode implements XmlNode
{
    /**
     * @var string
     */
    protected $loc;
    /**
     * @var string
     */
    protected $lastMod;
    /**
     * @var Map
     */
    protected $attributes;

    public function __construct(string $loc, string $lastMod = null)
    {
        $this->setLoc($loc);
    }

    /**
     * Return element.
     *
     * @param \DOMNode $node
     */
    public function save(\DOMNode $node): void
    {
        $element = new \DOMElement(static::getName());
        $node->appendChild($element);
        $this->appendAttributes($element);
        $this->appendChild($element);
    }

    /**
     * Set loc node.
     *
     * @param string $loc
     */
    public function setLoc(string $loc): void
    {
        $this->loc = $loc;
    }

    /**
     * Set last modification node (lastmod).
     *
     *
     * @param string|null $lastMod
     * @todo get value as Carbon instance.
     */
    public function setLastMod(string $lastMod = null): void
    {
        $this->lastMod = ($lastMod) ?: date('c', time());
    }

    /**
     * Set node attributes.
     *
     * @param Map $attr
     * @throws AttributeNameIsNotStringException
     * @throws AttributeValueIsNotScalarException
     */
    public function setAttributes(Map $attr): void
    {
        foreach ($attr as $k => $v) {
            if (!is_string($k))
                throw new AttributeNameIsNotStringException();
            if (!is_scalar($v))
                throw new AttributeValueIsNotScalarException();
        }
        $this->attributes = $attr;
    }

    /**
     * Append attributes to element, if exists.
     *
     * @param \DOMElement $el
     */
    protected function appendAttributes(\DOMElement $el): void
    {
        if (!$this->attributes || !$this->attributes->count())
            return;
        foreach ($this->attributes as $k => $v)
            $el->setAttribute($k, $v);
    }

    /**
     * Append child elements.
     *
     * @param \DOMElement $el
     */
    protected function appendChild(\DOMElement $el): void
    {
        $el->appendChild(new \DOMElement('loc', $this->loc));
        if ($this->lastMod)
            $el->appendChild(new \DOMElement('lastmod', $this->lastMod));
    }
}