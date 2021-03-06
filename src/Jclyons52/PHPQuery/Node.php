<?php

namespace Jclyons52\PHPQuery;

use Jclyons52\PHPQuery\Support\NodeCollection;

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

        if ($value !== null) {
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

    /**
     * @param array $styles
     * @return mixed
     * @throws \Exception
     */
    public function css($styles = [])
    {
        $css = $this->attr("style");

        $css = explode(";", $css);

        foreach ($css as $style) {
            $split = explode(':', $style);
            
            if (count($split) < 2) {
                continue;
            }
            
            $split = array_map('trim', $split);
            
            $result[$split[0]] = $split[1];
        }
        if ($styles !== []) {
            $result = array_merge($result, $styles);
            $this->attr("style", $this->arrayToCss($result));
        }

        return $result;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function data($key = null, $value = null)
    {
        if ($key !== null && $value !== null) {
            return $this->attr("data-{$key}", $value);
        }
        if ($key !== null) {
            return $this->attr("data-{$key}");
        }
        $dataAttributes = $this->getDataAttributeNames();

        foreach ($dataAttributes as $attribute) {
            $return[$attribute] = $this->attr("data-{$attribute}");
        }
        return $return;
    }

    /**
     * @param $result
     * @return string
     */
    private function arrayToCss($result)
    {
        $css = '';
        foreach ($result as $key => $value) {
            $css .= "{$key}:{$value};";
        }
        return $css;
    }

    /**
     * @return mixed
     */
    private function getDataAttributeNames()
    {
        $re = "/data-([A-Za-z0-9-]+)=/";
        $str = $this->toString();

        preg_match_all($re, $str, $matches);

        $dataAttributes = $matches[1];

        return $dataAttributes;
    }

    public function parent()
    {
        return new self($this->node->parentNode);
    }

    public function html()
    {
        $children = $this->node->childNodes;

        $results = new NodeCollection();

        foreach ($children as $child) {
            if ($child instanceof \DOMElement) {
                $results[] = new Node($child);
            }
        }
        return $results;
    }
}
