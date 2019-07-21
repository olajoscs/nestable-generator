<?php

namespace OlajosCs\Nestable;

use OlajosCs\Nestable\Elements\Element;
use OlajosCs\Nestable\Elements\NestableElement;

/**
 * Class ElementCollection
 *
 * Collection of the input elements which has to be passed to the generator
 */
class ElementCollection
{
    /**
     * @var Element[]
     */
    private $elements = [];

    /**
     * @var NestableElement To have a special nestable element class
     */
    private $nestableElementDummy;


    /**
     * This is a collection of the input elements which has to be passed to the generator
     *
     * @param Element[]       $elements               The array, which contains the basic elements, the source of the
     *                                                generation
     * @param NestableElement $nestableElementDummy   An empty NestableElement object, to have a "pattern" how to
     *                                                transform the Elements
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $elements, NestableElement $nestableElementDummy)
    {
        foreach ($elements as $element) {
            if (!$element instanceof Element) {
                throw new \InvalidArgumentException('This collection accepts only Element type');
            }

            $this->add($element);
        }

        $this->nestableElementDummy = $nestableElementDummy;
    }


    /**
     * Add an Element to the collection
     *
     * @param Element $element
     *
     * @return ElementCollection
     * @throws \InvalidArgumentException
     */
    public function add(Element $element): ElementCollection
    {
        if (isset($this->elements[$element->getId()])) {
            throw new \InvalidArgumentException('Input array has more than 1 elements with the same ID: ' . $element->getId());
        }

        $this->elements[$element->getId()] = $element;

        return $this;
    }


    /**
     * Return the empty nestable element object
     *
     * @return NestableElement
     */
    public function getNestableElementDummy(): NestableElement
    {
        return $this->nestableElementDummy;
    }


    /**
     * Return the element with the ID in the parameter
     *
     * @param int $id
     *
     * @return Element
     */
    public function get(int $id): Element
    {
        return $this->elements[$id];
    }


    /**
     * Return the added elements
     *
     * @return Element[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }
}
