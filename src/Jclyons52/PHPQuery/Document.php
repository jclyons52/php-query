<?php

namespace Jclyons52\PHPQuery;

use Jclyons52\PHPQuery\Support\NodeCollection;
use Symfony\Component\CssSelector\CssSelectorConverter;

class Document
{

    private $dom;

    private $xpath;

    public function __construct($html)
    {
        $this->dom = new \DOMDocument();

        $this->dom->loadHtml($html);

        $this->xpath = new \DOMXPath($this->dom);
    }

    /**
     * @param string $selector
     * @return Node
     */
    public function querySelector($selector)
    {
        $converter = new CssSelectorConverter();

        $xpathQuery = $converter->toXPath($selector);

        $result = $this->xpath->query($xpathQuery);

        return new Node($result->item(0));

    }

    /**
     * @param string $selector
     * @return NodeCollection
     */
    public function querySelectorAll($selector)
    {
        $converter = new CssSelectorConverter();

        $xpathQuery = $converter->toXPath($selector);

        $results = $this->xpath->query($xpathQuery);

        $return = new NodeCollection();

        for ($i = 0; $i < $results->length; $i++) {
            $node = new Node($results->item($i));
            $return->append($node);
        }

        return $return;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->dom->saveHTML();

    }
}
