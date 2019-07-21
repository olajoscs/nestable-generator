<?php

namespace OlajosCs\Nestable;

use OlajosCs\Nestable\Models\Element;
use OlajosCs\Nestable\Models\NestableElement;
use PHPUnit\Framework\TestCase;

/**
 * Class NestableGeneratorTest
 *
 * Tests for the NestableGenerator class
 */
class NestableGeneratorTest extends TestCase
{
    /**
     * Test the JSON generation from the unordered list
     */
    public function testJsonGeneration(): void
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
        $elementCollection = new ElementCollection($elements, new NestableElement());
        $json = '[{"id":3,"content":"1","children":[{"id":6,"content":"1.1"},{"id":9,"content":"1.2","children":[{"id":8,"content":"1.2.1"}]},{"id":2,"content":"1.3"}]},{"id":4,"content":"2","children":[{"id":7,"content":"2.1","children":[{"id":1,"content":"2.1.1"}]}]},{"id":5,"content":"3"}]';

        $generator = new NestableGenerator($elementCollection);

        $this->assertEquals($json, $generator->generate());
    }


    /**
     * Test the JSON generation from an empty list
     */
    public function testEmptyGeneration(): void
    {
        $generator = new NestableGenerator(new ElementCollection([], new NestableElement()));

        $this->assertEquals('[]', $generator->generate());
    }


    /**
     * Test the JSON parse to create the ordered element list
     */
    public function testJsonParse(): void
    {
        $elementsFromDatabase = [
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

        $reOrderedElements = [
            new Element(3, '1', null, 0),
            new Element(6, '1.1', 3, 0),
            new Element(5, '3', 6, 0),
            new Element(9, '1.2', 3, 1),
            new Element(2, '1.3', 9, 0),
            new Element(8, '1.2.1', 9, 1),
            new Element(4, '2', null, 1),
            new Element(1, '2.1.1', 4, 0),
            new Element(7, '2.1', 4, 1),
        ];

        $generator = new NestableGenerator(new ElementCollection($elementsFromDatabase, new NestableElement()));
        $json = '[{"id":3,"content":"1","children":[{"id":6,"content":"1.1","children":[{"id":5,"content":"3"}]},{"id":9,"content":"1.2","children":[{"id":2,"content":"1.3"},{"id":8,"content":"1.2.1"}]}]},{"id":4,"content":"2","children":[{"id":1,"content":"2.1.1"},{"id":7,"content":"2.1"}]}]';

        $this->assertEquals($reOrderedElements, $generator->fromJson($json));
    }


    /**
     * Test the JSON parse from an "empty" string
     */
    public function testEmptyJsonParse(): void
    {
        $generator = new NestableGenerator(new ElementCollection([], new NestableElement()));

        $this->assertEquals([], $generator->fromJson('[]'));
        $this->assertEquals([], $generator->fromJson('{}'));
        $this->assertEquals([], $generator->fromJson(''));
        $this->assertEquals([], $generator->fromJson('null'));
    }
}
