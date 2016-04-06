<?php

namespace Jclyons52\PHPQuery;

class Node
{
    public $node;

    public function __construct(\DOMNode $node)
    {
        $this->node = $node;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->node->ownerDocument->saveHTML($this->node);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @return string
     * @throws \Exception
     */
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

    /**
     * @return string
     */
    public function text()
    {
        return $this->node->textContent;
    }


    /**
     *
     */
    public function remove()
    {
        $this->node->parentNode->removeChild($this->node);
    }

    /**
     * @param string $class
     * @return bool
     * @throws \Exception
     */
    public function hasClass($class)
    {
        $classes = explode(' ', $this->attr('class'));

        return in_array($class, $classes);
    }
}
