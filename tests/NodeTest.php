<?php

use Jclyons52\PHPQuery\Document;
use Jclyons52\PHPQuery\Node;
use Jclyons52\PHPQuery\Support\NodeCollection;

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

    /**
     * @test
     */
    public function it_gets_css_as_associative_array()
    {
        $css = $this->node->css();

        $this->assertEquals(["color" => "blue", "display" => "none"], $css);
    }

    /**
     * @test
     */
    public function it_sets_css_with_associative_array()
    {
        $css = $this->node->css(["display" => "block", "font-family" => "Helvetica"]);

        $this->assertEquals(["color" => "blue", "display" => "block", "font-family" => "Helvetica"], $css);
    }
    
    /**
     * @test
     */
    public function it_gets_the_dataset()
    {
        $node = $this->document->querySelectorAll('.col-sm-3')[2];
        $data = $node->data();
        $expected = ["last-value" => "43", "hidden" => "true", "options" => '{"name":"John"}'];
        
        $this->assertEquals($expected, $data);
    }

    /**
     * @test
     */
    public function it_returns_the_value_of_a_data_property()
    {
        $node = $this->document->querySelectorAll('.col-sm-3')[2];
        $data = $node->data("last-value");

        $this->assertEquals("43", $data);
    }

    /**
     * @test
     */
    public function it_sets_the_value_of_a_data_property()
    {
        $node = $this->document->querySelectorAll('.col-sm-3')[2];
        $data = $node->data("last-value", 27);

        $this->assertEquals("27", $data);
    }

    /**
     * @test
     */
    public function it_gets_the_parent_node()
    {
        $this->assertTrue($this->node->parent()->hasClass('row'));
    }

    /**
     * @test
     */
    public function it_gets_the_inner_html_of_node()
    {
        $innerHtml = $this->document->querySelector('.row')->html();

        $this->assertInstanceOf(NodeCollection::class, $innerHtml);

        $this->assertEquals(3, $innerHtml->count());
    }
}

