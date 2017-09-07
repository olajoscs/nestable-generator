<?php

namespace OlajosCs\Nestable\Elements;

/**
 * Class AbstractNestableElement
 *
 * Basic implementation of the NestableElement, which is needed in the NestableGenerator class
 */
abstract class AbstractNestableElement implements NestableElement
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var int
     */
    protected $parentId;

    /**
     * @var
     */
    protected $index;

    /**
     * @var NestableElement[]
     */
    protected $children = [];


    /**
     * Create a new Nestable element from the basic element
     *
     * @param Element $element
     *
     * @return NestableElement
     */
    public static function create(Element $element): NestableElement
    {
        $nestableElement = new static();

        $nestableElement->id       = $element->getId();
        $nestableElement->content  = $element->getName();
        $nestableElement->parentId = $element->getParentId();
        $nestableElement->index    = $element->getIndex();

        return $nestableElement;
    }


    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed Data which can be serialized by <b>json_encode</b>,
     */
    public function jsonSerialize()
    {
        $return = [
            'id'      => $this->getId(),
            'content' => $this->getContent(),
        ];

        if (!empty($this->children)) {
            $return += ['children' => $this->getChildren()];
        }

        return $return;
    }


    /**
     * Return the ID of the element
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * Return the content of the element.
     * This will be showed on the labels.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }


    /**
     * Return the parent ID of the element
     *
     * @return int
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }


    /**
     * Return the children of the element
     *
     * @return NestableElement[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }


    /**
     * Set the children of the element
     *
     * @param NestableElement[] $children
     *
     * @return NestableElement
     */
    public function setChildren(array $children): NestableElement
    {
        $this->children = $children;

        return $this;
    }


    /**
     * Add a child to the children list
     *
     * @param NestableElement $element
     *
     * @return NestableElement
     */
    public function addChild(NestableElement $element): NestableElement
    {
        $this->children[] = $element;

        return $this;
    }


    /**
     * Return the index of the element on the given level
     *
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }


    /**
     * Set the index of the element on the given level
     *
     * @param int $index
     *
     * @return NestableElement
     */
    public function setIndex(int $index): NestableElement
    {
        $this->index = $index;

        return $this;
    }
}
