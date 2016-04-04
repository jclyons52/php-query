<?php

namespace Jclyons52\PHPQuery;

class Node
{
    private $node;

    public function __construct(\DOMNode $node)
    {
        $this->node = $node;
    }

    public function toString()
    {
        return $this->node->ownerDocument->saveHTML($this->node);
    }
}