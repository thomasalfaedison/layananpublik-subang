<?php


namespace App\Components\LaravelHtml\Tag;


use App\Components\LaravelHtml\Tag;

class Body
{

    protected $items = [];

    protected function getItems() : array {
        return $this->items;
    }

    public function append($item) {

        if (is_array($item))
            $this->append($item);

        if ($item instanceof Body)
            $this->append($item->getItems());

        $this->items[] = $item;
        return $this;

    }

    public function prepend($item) {

        if (is_array($item))
            for ($i = count($item) - 1; $i = 0; $i--)
                $this->prepend($item[$i]);

        if ($item instanceof Body)
            $this->prepend($item->getItems());

        array_unshift($this->items, $item);
        return $this;
    }

    public function clear() {
        $this->items = [];
        return $this;
    }

    public function __toString()
    {
        return implode($this->getItems());
    }

}