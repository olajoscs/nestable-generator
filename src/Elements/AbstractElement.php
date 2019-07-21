<?php

declare(strict_types=1);

namespace OlajosCs\Nestable\Elements;

/**
 * Class AbstractElement
 *
 * Basic implementation of the Element, which is needed in the NestableGenerator class
 */
abstract class AbstractElement implements Element
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int|null
     */
    protected $parentId;

    /**
     * @var int
     */
    protected $index;


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
     * Return the name of the element
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * Set the parent ID of the element
     *
     * @param int|null $id
     *
     * @return void
     */
    public function setParentId(?int $id): void
    {
        $this->parentId = $id;
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
     * @return void
     */
    public function setIndex(int $index): void
    {
        $this->index = $index;
    }
}
