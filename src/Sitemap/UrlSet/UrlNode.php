<?php
/**
 * Created by PhpStorm.
 * User: webengineer
 * Date: 30.11.18
 * Time: 13:39
 */

namespace SitemapGenerator\Sitemap\UrlSet;


use SitemapGenerator\Abstraction\AbstractXmlNode;
use SitemapGenerator\Exceptions\UnsupportedChangeFreqValueException;

class UrlNode extends AbstractXmlNode
{
    const CHANGE_FREQ_LIST = ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'];
    //todo: add constants with changefreq values.
    /**
     * @var float
     */
    protected $priority;
    /**
     * @var string
     */
    protected $changeFreq;

    /**
     * Set priority node.
     *
     * @param float $priority
     */
    public function setPriority(float $priority): void
    {
        if ($priority <= 1 && $priority > 0)
            $this->priority = $priority;
    }

    /**
     * Set change frequency node (changefreq).
     *
     * @param string $changeFreq
     * @throws UnsupportedChangeFreqValueException
     */
    public function setChangeFreq(string $changeFreq): void
    {
        if (!in_array($changeFreq, self::CHANGE_FREQ_LIST))
            throw new UnsupportedChangeFreqValueException($changeFreq);
        $this->changeFreq = $changeFreq;
    }

    /**
     * @inheritdoc
     */
    protected function appendChild(\DOMElement $el): void
    {
        parent::appendChild($el);
        if ($this->priority)
            $el->appendChild(new \DOMElement('priority', $this->priority));
        if ($this->changeFreq)
            $el->appendChild(new \DOMElement('changefreq', $this->changeFreq));
    }

    /**
     * Return tag name.
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'url';
    }
}