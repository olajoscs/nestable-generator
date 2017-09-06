<?php

namespace OlajosCs\Nestable;

use OlajosCs\Nestable\Models\Element;
use OlajosCs\Nestable\Models\NestableElement;

/**
 * Class NestableElementCollectionTest
 *
 * Tests for the ElementCollection class
 */
class ElementCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test when elements of Element type are added to the collection
     */
    public function testWhenElementAdded()
    {
        $collection = new ElementCollection([], new NestableElement());

        $added = new Element(1, '1', null, 0);
        $collection->add($added);


        $this->assertCount(1, $collection->getElements());
        $this->assertSame([$added->getId() => $added], $collection->getElements());
        $this->assertEquals($added, $collection->get(1));
    }


    /**
     * Test when elements of NOT Element type are added to the collection in the constructor
     */
    public function testWhenNotElementAddedInConstructor()
    {
        $this->expectException(\InvalidArgumentException::class);
        new ElementCollection([new \stdClass()], new NestableElement());
    }


    /**
     * Test when elements of NOT Element type are added to the collection
     */
    public function testWhenNotElementAdded()
    {
        $collection = new ElementCollection([], new NestableElement());

        $this->expectException(\TypeError::class);
        $collection->add(new \stdClass());
    }


    /**
     * Test when multiple elements are added with the same ID
     */
    public function testWhenMultipleElementsAreAddedWithSameID()
    {
        $collection = new ElementCollection([], new NestableElement());
        $element    = new Element(1, '1', null, 0);

        $this->expectException(\InvalidArgumentException::class);

        $collection->add($element)->add($element);
    }
}
