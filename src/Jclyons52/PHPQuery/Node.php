<?php

namespace Jclyons52\PHPQuery;

class Node
{
    public $node;

    public function __construct(\DOMNode $node)
    {
        $this->node = $node;
    }

    public function toString()
    {
        return $this->node->ownerDocument->saveHTML($this->node);
    }

    public function attr($name, $value = null)
    {
        if (!($this->node instanceof \DOMElement)) {
            throw new \Exception('dom node is not of type element');
        }

        if ($value) {
            $this->node->setAttribute($name, $value);
        }
        
        return $this->node->getAttribute($name);
    }

    public function text()
    {
        return $this->node->textContent;
    }

    public function remove()
    {
        $this->node->parentNode->removeChild($this->node);
    }
}
