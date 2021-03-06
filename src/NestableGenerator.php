<?php

declare(strict_types=1);

namespace OlajosCs\Nestable;

use OlajosCs\Nestable\Elements\Element;
use OlajosCs\Nestable\Elements\NestableElement;

/**
 * Class NestableGenerator
 *
 * Generator of the json, which is used to display the nested elements block.
 */
class NestableGenerator
{
    /**
     * @var ElementCollection
     */
    private $elementCollection;


    /**
     * Create a new NestableGenerator object
     *
     * @param ElementCollection $elementCollection
     */
    public function __construct(ElementCollection $elementCollection)
    {
        $this->elementCollection = $elementCollection;
    }


    /**
     * Generate the list of the basic elements from the JSON string, which is generated by the nestable JS library
     *
     * @param string $json
     *
     * @return Element[]
     */
    public function fromJson(string $json): array
    {
        $decodedStdClasses = json_decode($json, false);

        if (!is_array($decodedStdClasses)) {
            return [];
        }

        $structure = $this->transform($decodedStdClasses);

        return $this->flatten($structure);
    }


    /**
     * Generate the JSON - which can be given to the JS library - string from the list of the basic elements
     *
     * @return string
     */
    public function generate(): string
    {
        $structure = $this->createStructure();

        return json_encode($structure);
    }


    /**
     * Transform the decoded JSON to NestableElement objects
     *
     * @param \stdClass[] $structure
     * @param int         $index
     *
     * @return NestableElement[]
     */
    private function transform(array $structure, int $index = 0): array
    {
        $nestableElementDummy = $this->elementCollection->getNestableElementDummy();
        $elements = [];
        foreach ($structure as $item) {
            $element = $this->elementCollection->get($item->id);

            $displayed = $nestableElementDummy::create($element);
            $displayed->setIndex($index);

            if (!empty($item->children)) {
                $displayed->setChildren($this->transform($item->children));
            }

            $elements[] = $displayed;
            $index++;
        }

        return $elements;
    }


    /**
     * Flatten the NestableElement objects structure, and convert them to basic Element objects
     *
     * @param NestableElement[] $structure
     * @param int|null          $parentId
     *
     * @return Element[]
     */
    private function flatten(array $structure, ?int $parentId = null): array
    {
        $elements = [];
        foreach ($structure as $element) {
            $newElement = $this->elementCollection->get($element->getId());
            $newElement->setParentId($parentId);
            $newElement->setIndex($element->getIndex());

            $elements[] = $newElement;

            if (!empty($element->getChildren())) {
                $elements = array_merge($elements, $this->flatten($element->getChildren(), $element->getId()));
            }
        }

        return $elements;
    }


    /**
     * Create a NestableElement structure from the basic element array.
     * Child objects - which have valid parent ID - will become nested into their parent's children array.
     *
     * @return NestableElement[]
     */
    private function createStructure(): array
    {
        $nestableElementDummy = $this->elementCollection->getNestableElementDummy();
        $tempList = [];
        $displayedList = [];
        foreach ($this->elementCollection->getElements() as $element) {
            $tempList[$element->getId()] = $nestableElementDummy::create($element);
        }

        uasort($tempList, static function (NestableElement $a, NestableElement $b) {
            return $a->getIndex() <=> $b->getIndex();
        });

        foreach ($tempList as $element) {
            if ($element->getParentId()) {
                $tempList[$element->getParentId()]->addChild($element);
            }
        }

        foreach ($tempList as $element) {
            if ($element->getParentId() === null) {
                $displayedList[] = $element;
            }
        }

        return $displayedList;
    }
}
