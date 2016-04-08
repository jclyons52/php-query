<?php

use Jclyons52\PHPQuery\Document;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    protected $html;

    protected $documnet;

    public function setup()
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
                <div class="col-sm-3" id="div-1"> First Div </div>
                <div class="col-sm-3" id="div-2"> Second Div </div>
                <div class="col-sm-3" id="div-3"> Third Div </div>
            </div>
            </body>
            </html>';

        $this->document = new Document($this->html);

    }

    /**
     * @test
     */
    public function it_finds_first_element_by_class()
    {
        $element = $this->document->querySelector('.col-sm-3');

        $this->assertEquals('<div class="col-sm-3" id="div-1"> First Div </div>', $element->toString());
    }

    /**
     * @test
     */
    public function it_returns_null_if_no_element_is_found()
    {
        $element = $this->document->querySelector('.foo-bar-foo');

        $this->assertEquals(null , $element);
    }

    /**
     * @test
     */
    public function it_finds_all_elements_by_class()
    {
        $elements = $this->document->querySelectorAll('.col-sm-3');

        $this->assertEquals(3, count($elements));
    }

    /**
     * @test
     */
    public function it_returns_empty_array_if_no_element_is_found()
    {
        $element = $this->document->querySelectorAll('.foo-bar-foo');

        $this->assertEquals([] , $element);
    }

    /**
     * @test
     */
    public function it_finds_element_by_id()
    {
        $element = $this->document->querySelector('#div-1');

        $this->assertEquals('<div class="col-sm-3" id="div-1"> First Div </div>', $element->toString());
    }

    /**
     * @test
     */
    public function it_can_be_converted_to_string()
    {
        $html = $this->html;

        $documentString = $this->document->toString();

        $doc1 = new Document($html);
        $doc1 = $doc1->toString();
        $doc2 = new Document($documentString);
        $doc2 = $doc2->toString();

        $this->assertEquals($doc1, $doc2);
    }
}