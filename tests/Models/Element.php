<?php

namespace OlajosCs\Nestable\Models;

use OlajosCs\Nestable\Elements\AbstractElement;

class Element extends AbstractElement
{
    public function __construct($id, $name, $parentId, $index)
    {
        $this->id       = $id;
        $this->name     = $name;
        $this->parentId = $parentId;
        $this->index    = $index;
    }
}
