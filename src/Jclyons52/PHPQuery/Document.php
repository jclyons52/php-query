<?php

namespace Jclyons52\PHPQuery;

use Jclyons52\PHPQuery\Support\NodeCollection;
use Symfony\Component\CssSelector\CssSelectorConverter;

class Document
{
    use AjaxTrait;

    private $dom;

    private $xpath;

    public function __construct($html)
    {
        libxml_use_internal_errors(true);

        $this->dom = new \DOMDocument();

        $this->dom->loadHtml($html);

        $this->xpath = new \DOMXPath($this->dom);
    }

    public function __invoke($selector)
    {
        $nodes = $this->querySelectorAll($selector);

        if (count($nodes) === 1) {
            return $nodes[0];
        }

        return $nodes;
    }

    /**
     * select single element from dom using css style selectors
     * @param string $selector
     * @return Node
     */
    public function querySelector($selector)
    {
        $converter = new CssSelectorConverter();

        $xpathQuery = $converter->toXPath($selector);

        $result = $this->xpath->query($xpathQuery);

        if (!$result->item(0)) {
            return null;
        }
        return new Node($result->item(0));
    }

    /**
     * select multiple elements from dom using css style selectors
     * @param string $selector
     * @return NodeCollection
     */
    public function querySelectorAll($selector)
    {
        $converter = new CssSelectorConverter();

        $xpathQuery = $converter->toXPath($selector);

        $results = $this->xpath->query($xpathQuery);

        if (!$results->item(0)) {
            return [];
        }

        $return = new NodeCollection();

        for ($i = 0; $i < $results->length; $i++) {
            $node = new Node($results->item($i));
            $return->append($node);
        }

        return $return;
    }

    /**
     * Converts DOM to string
     * @return string
     */
    public function toString()
    {
        return $this->dom->saveHTML();
    }
}
