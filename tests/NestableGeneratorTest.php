<?php

namespace OlajosCs\Nestable;

use OlajosCs\Nestable\Models\Element;
use OlajosCs\Nestable\Models\NestableElement;

/**
 * Class NestableGeneratorTest
 *
 * Tests for the NestableGenerator class
 */
class NestableGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ElementCollection
     */
    protected $elementCollection;

    /**
     * @var string Input json from Nestable js
     */
    protected $json;

    /**
     * @var Element[] Elements, which are in proper order
     */
    protected $orderedElements;


    protected function setUp()
    {
        $elements = [
            new Element(1, '2.1.1', 7, 0),
            new Element(2, '1.3', 3, 2),
            new Element(3, '1', null, 0),
            new Element(4, '2', null, 0),
            new Element(5, '3', null, 0),
            new Element(6, '1.1', 3, 0),
            new Element(7, '2.1', 4, 0),
            new Element(8, '1.2.1', 9, 0),
            new Element(9, '1.2', 3, 1),
        ];


        $this->orderedElements = [
            new Element(3, '1', null, 0),
            new Element(6, '1.1', 3, 0),
            new Element(9, '1.2', 3, 1),
            new Element(8, '1.2.1', 9, 0),
            new Element(2, '1.3', 3, 2),
            new Element(4, '2', null, 1),
            new Element(7, '2.1', 4, 0),
            new Element(1, '2.1.1', 7, 0),
            new Element(5, '3', null, 2),
        ];

        $this->elementCollection = new ElementCollection($elements, new NestableElement());
        $this->json              = '[{"id":3,"content":"1","children":[{"id":6,"content":"1.1"},{"id":9,"content":"1.2","children":[{"id":8,"content":"1.2.1"}]},{"id":2,"content":"1.3"}]},{"id":4,"content":"2","children":[{"id":7,"content":"2.1","children":[{"id":1,"content":"2.1.1"}]}]},{"id":5,"content":"3"}]';
    }


    /**
     * Test the JSON generation from the unordered list
     */
    public function testJsonGeneration()
    {
        $generator = new NestableGenerator($this->elementCollection);

        $this->assertEquals($this->json, $generator->generate());
    }


    /**
     * Test the JSON parse to create the ordered element list
     */
    public function testJsonParse()
    {
        $generator = new NestableGenerator($this->elementCollection);

        $this->assertEquals($this->orderedElements, $generator->fromJson($this->json));
    }
}