<?php

namespace OlajosCs\Nestable\Models;

use OlajosCs\Nestable\Elements\AbstractElement;
use OlajosCs\Nestable\Elements\Element as ElementInterface;

class Element extends AbstractElement implements ElementInterface
{
    public function __construct($id, $name, $parentId, $index)
    {
        $this->id       = $id;
        $this->name     = $name;
        $this->parentId = $parentId;
        $this->index    = $index;
    }
}
