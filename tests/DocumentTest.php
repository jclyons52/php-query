<?php

use Jclyons52\PHPQuery\Document;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    protected $html;

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

    }

    /**
     * @test
     */
    public function it_finds_first_element_by_class()
    {
        $document = new Document($this->html);

        $element = $document->querySelector('.col-sm-3');

        $this->assertEquals('<div class="col-sm-3" id="div-1"> First Div </div>', $element->toString());
    }

    /**
     * @test
     */
    public function it_finds_all_elements_by_class()
    {
        $document = new Document($this->html);
        
        $elements = $document->querySelectorAll('.col-sm-3');

        $this->assertEquals(3, count($elements));

    }

    /**
     * @test
     */
    public function it_finds_element_by_id()
    {
        $document = new Document($this->html);

        $element = $document->querySelector('#div-1');

        $this->assertEquals('<div class="col-sm-3" id="div-1"> First Div </div>', $element->toString());
    }

    /**
     * @test
     */
    public function it_can_be_converted_to_string()
    {
        $html = $this->html;

        $document = new Document($this->html);

        $documentString = $document->toString();

        $doc1 = new Document($html);
        $doc1 = $doc1->toString();
        $doc2 = new Document($documentString);
        $doc2 = $doc2->toString();


        $this->assertEquals($doc1, $doc2);
    }

    protected function stripWhitespaces($string)
    {
        $search = array(
            '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
            '/[^\S ]+\</s',  // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        );

        $replace = array(
            '>',
            '<',
            '\\1'
        );

        return preg_replace($search, $replace, $string);
    }

}