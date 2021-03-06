<?php

declare(strict_types=1);

namespace OlajosCs\Nestable\Elements;

/**
 * Interface Element
 *
 * Interface for the element, from what the list would be generated
 */
interface Element
{
    /**
     * Return the ID of the element
     *
     * @return int
     */
    public function getId(): int;


    /**
     * Return the name of the element
     *
     * @return string
     */
    public function getName(): string;


    /**
     * Return the parent ID of the element
     *
     * @return int
     */
    public function getParentId(): ?int;


    /**
     * Set the parent ID of the element
     *
     * @param int|null $id
     *
     * @return void
     */
    public function setParentId(?int $id): void;


    /**
     * Return the index of the element on the given level
     *
     * @return int
     */
    public function getIndex(): int;


    /**
     * Set the index of the element on the given level
     *
     * @param int $index
     *
     * @return void
     */
    public function setIndex(int $index): void;
}
