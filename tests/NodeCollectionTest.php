<?php

use Jclyons52\PHPQuery\Document;

class NodeCollectionTest extends PHPUnit_Framework_TestCase
{
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
                <div class="col-sm-3" id="div-2" style="color: green; display: none;"> Second Div </div>
                <div class="col-sm-3" id="div-3" style="color: red; display: none;" > Third Div </div>
            </div>
            </body>
            </html>';

        $this->document = new Document($this->html);
    }

    /**
     * @test
     */
    public function it_gets_text_from_multiple_elements()
    {
        $nodes = $this->document->querySelectorAll('.col-sm-3');

        $strings = $nodes->text();

        $this->assertEquals(' First Div ', $strings[0]);
        $this->assertEquals(' Second Div ', $strings[1]);
        $this->assertEquals(' Third Div ', $strings[2]);
    }

    public function it_gets_attributes_from_multiple_elements()
    {
        $nodes = $this->document->querySelectorAll('.col-sm-3');

        $attributes = $nodes->attr('style');

        $this->assertEquals('color: blue; display: none;', $attributes[0]);
        $this->assertEquals('color: green; display: none;', $attributes[0]);
        $this->assertEquals('color: red; display: none;', $attributes[0]);
    }

    /**
     * @test
     */
    public function it_sets_attributes_on_multiple_elements()
    {
        $nodes = $this->document->querySelectorAll('.col-sm-3');

        $nodes->attr('style', 'display: block;');

        $newStyles = $this->document->querySelectorAll('.col-sm-3')->attr('style');

        $this->assertEquals('display: block;', $newStyles[0]);
    }

    /**
     * @test
     */
    public function it_can_use_standard_array_methods()
    {
        $nodes = $this->document->querySelectorAll('.col-sm-3');

        $keys = $nodes->array_keys();

        $this->assertEquals([0,1,2], $keys);
    }

    /**
     * @test
     */
    public function it_doesnt_try_to_magically_call_methods_not_beginning_with_array()
    {
        $nodes = $this->document->querySelectorAll('.col-sm-3');

        $this->setExpectedException(\BadMethodCallException::class);

        $nodes->keys();
    }
}