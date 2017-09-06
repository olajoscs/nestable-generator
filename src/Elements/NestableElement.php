<?php

namespace OlajosCs\Nestable\Elements;

/**
 * Interface NestableElementInterface
 *
 * Interface of the elements, which are used to generate json
 */
interface NestableElement extends \JsonSerializable
{
    /**
     * Return the ID of the element
     *
     * @return int
     */
    public function getId(): int;


    /**
     * Return the content of the element.
     * This will be showed on the labels.
     *
     * @return string
     */
    public function getContent(): string;


    /**
     * Return the parent ID of the element
     *
     * @return int
     */
    public function getParentId(): ?int;


    /**
     * Return the children of the element
     *
     * @return NestableElement[]
     */
    public function getChildren(): array;


    /**
     * Set the children of the element
     *
     * @param NestableElement[] $children
     *
     * @return NestableElement
     */
    public function setChildren(array $children): NestableElement;


    /**
     * Add a child to the children list
     *
     * @param NestableElement $element
     *
     * @return NestableElement
     */
    public function addChild(NestableElement $element): NestableElement;


    /**
     * Create a new Nestable element from the basic element
     *
     * @param Element $element
     *
     * @return NestableElement
     */
    public static function create(Element $element): NestableElement;


    /**
     * Return the index of the element on the given level
     *
     * @return int
     */
    public function getIndex(): int;
}
