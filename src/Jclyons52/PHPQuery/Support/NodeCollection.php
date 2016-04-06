<?php

namespace Jclyons52\PHPQuery\Support;

class NodeCollection extends \ArrayObject
{
    /**
     * Allows array methods to be called on object
     *
     * @param  $func
     * @param  $argv
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($func, $argv)
    {
        if (!is_callable($func) || substr($func, 0, 6) !== 'array_') {
            throw new \BadMethodCallException(__CLASS__.'->'.$func);
        }
        return call_user_func_array($func, array_merge(array($this->getArrayCopy()), $argv));
    }

    /**
     * @return array
     */
    public function text()
    {
        $text = [];
        
        foreach ($this as $node) {
            $text[] =  $node->text();
        }

        return $text;
    }

    /**
     * @param string $name
     * @param string|null $value
     * @return array
     */
    public function attr($name, $value = null)
    {
        $attr = [];

        foreach ($this as $node) {
            $attr[] =  $node->attr($name, $value);
        }

        return $attr;
    }
}
