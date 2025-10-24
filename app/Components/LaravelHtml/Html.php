<?php

namespace App\Components\LaravelHtml\Html;

class Html
{

    protected $selfClosed = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr', 'command', 'keygen', 'menuitem'
    ];

    public function tag(string $name, array $attributes = [], bool $selfClosing = false) : Tag {
        $tag = new Tag($name, $attributes, $selfClosing);

        if (in_array($name, $this->selfClosed))
            $tag->selfClosing();

        return  $tag;
    }

    public function __call($name, $arguments)
    {
        array_unshift($arguments, $name);
        return call_user_func_array([$this, 'tag'], $arguments);
    }

}
