<?php

use Jclyons52\PHPQuery\Document;
use Jclyons52\PHPQuery\Node;

class NodeTest extends PHPUnit_Framework_TestCase
{
    protected $node;

    public function setUp()
    {

        $this->html = '
        <!doctype html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Document</title>
            </head>
            <body>
            <div class="row">
                <div class="col-sm-3" id="div-1" style="color: blue; display: none;"> First Div </div>
            </div>
            </body>
            </html>';

        $document = new Document($this->html);

        $this->node = $document->querySelector('.col-sm-3');
    }

    /**
     * @test
     */
    public function it_gets_attribute_from_element()
    {
        $styles = $this->node->attr('style');

        $this->assertEquals($styles, 'color: blue; display: none;');
    }

    /**
     * @test
     */
    public function it_sets_attribute_from_element()
    {
        $styles = $this->node->attr('styles', 'color: blue; display: block;');

        $this->assertEquals($styles, 'color: blue; display: block;');
    }

    /**
     * @test
     */
    public function it_rejects_non_element_node()
    {
        $styleNode = new Node($this->node->node->getAttributeNode('style'));

        $this->setExpectedException(\Exception::class);

        $styleNode->attr('styles');
    }
}