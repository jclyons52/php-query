<?php

use Jclyons52\PHPQuery\Document;
use Jclyons52\PHPQuery\Node;

class NodeTest extends PHPUnit_Framework_TestCase
{
    protected $node;

    protected $document;

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
                <div class="col-sm-3 first" id="div-1" style="color: blue; display: none;"> First Div </div>
                <div class="col-sm-3 second" id="div-2"> Second Div </div>
                <div class="col-sm-3 third" id="div-3" data-last-value="43" data-hidden="true" data-options=\'{"name":"John"}\'> Third Div </div>
            </div>
            </body>
            </html>';

        $this->document = new Document($this->html);

        $this->node = $this->document->querySelector('.col-sm-3');
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

    /**
     * @test
     */
    public function it_gets_the_text_from_an_element()
    {
        $text = $this->node->text();

        $this->assertEquals(' First Div ', $text);
    }

    /**
     * @test
     */
    public function it_removes_element_from_the_dom()
    {
        $this->node->remove();

        $elements = $this->document->querySelectorAll('.col-sm-3');

        $this->assertEquals(2, count($elements));
    }

    /**
     * @test
     */
    public function it_checks_if_item_has_class()
    {
        $this->assertTrue($this->node->hasClass('first'));
    }
}