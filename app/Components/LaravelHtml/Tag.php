<?php

namespace App\Components\LaravelHtml;


use App\Components\LaravelHtml\Tag\Body;

class Tag {

    private $props = [];
    private $attributes = [];
    private $body;

    public function __construct($name, array $attributes = [], bool $selfClosing = false)
    {

        $this->body = new Body();

        $this
            ->setName($name)
            ->setAttributes($attributes)
            ->setProperty('self_closing', $selfClosing);

    }

    protected function setProperty(string $name, $value = null) {
        $this->props[$name] = $value;
        return $this;
    }

    protected function getProperty(string $name) {
        return $this->props[$name] ?? null;
    }

    // START PROPERTIES

    public function setName($name) {
        return $this->setProperty('name', $name);
    }

    public function getName() {
        return $this->getProperty('name');
    }

    public function selfClosing() {
        return $this->setProperty('self_closing', true);
    }

    protected function isSelfClosing() {
        return $this->getProperty('self_closing') === true;
    }

    // END PROPERTIES

    // START BODY

    public function getBody() : Body {
        return $this->body;
    }

    public function clearBody() {
        $this->body->clear();
        return $this;
    }

    public function appendBody($value) {
        $this->body->append($value);
        return $this;
    }

    public function prependBody($value) {
        $this->body->prepend($value);
        return $this;
    }

    // END BODY

    // START ATTRIBUTES

    public function setAttributes(array $attributes) {
        $this->attributes = $attributes;
        return $this;
    }

    public function getAttributes() : array {
        return $this->attributes;
    }

    public function setAttribute(string $name, string $value = null) {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function getAttribute(string $name) {
        return $this->attributes[$name] ?? null;
    }

    public function appendAttribute(string $name, string $value) {
        return $this->setAttribute($name, $this->getAttribute($name) . $value);
    }

    public function prependAttribute(string $name, string $value) {
        return $this->setAttribute($name, $value . $this->getAttribute($name));
    }

    // END ATTRIBUTES

    // START RENDERING

    public function start() {

        $start = "<{$this->getName()}";

        foreach ($this->getAttributes() as $key => $value) {
            $start .= " {$key}";

            if ($value != null)
                $start .= "=\"{$value}\"";

        }

        $start .= $this->isSelfClosing() ? " />" : ">";

        return $start;

    }

    public function end() {

        if ($this->isSelfClosing())
            return null;

        return "</{$this->getName()}>";
    }

    public function __toString() : string
    {

        $tag = $this->start();

        if (!$this->isSelfClosing())
            $tag .= $this->getBody() . $this->end();

        return $tag;
    }

    // END RENDERING



    /*
     * ATTRIBUTES
     */

    // START CLASS ATTRIBUTE

    public function setClass(string $class) {
        return $this->setAttribute('class', $class);
    }

    public function addClass($class) {
        return $this->appendAttribute('class', ($this->getAttribute('class') ? ' ' : '' ) . $class);
    }

    // END CLASS ATTRIBUTE

    public function setAccessKey(string $key) {
        return $this->setAttribute('accesskey', $key);
    }

    public function setContentEditable(bool $editable) {
        return $this->setAttribute('contenteditable', $editable ? "true" : "false");
    }

    /**
     * @param string $id
     * @return $this
     * @deprecated Only firefox handle this attribute
     */
    public function setContextMenu(string $id) {
        return $this->setAttribute('contextmenu', $id);
    }

    public function rtl() {
        return $this->setAttribute('dir', 'rtl');
    }

    public function ltr() {
        return $this->setAttribute('dir', 'ltr');
    }

    public function hidden() {
        return $this->setAttribute('hidden');
    }

    public function setId(string $id) {
        return $this->setAttribute('id', $id);
    }

    public function setLang($code) {
        return $this->setAttribute('lang', $code);
    }

    public function setSpellCheck(bool $check) {
        return $this->setAttribute('spellcheck', $check ? "true" : "false");
    }

    public function setTitle($title) {
        return $this->setAttribute('title', $title);
    }

    // START STYLE ATTRIBUTE

    public function setStyle(string $style) {
        return $this->setAttribute('style', $style);
    }

    public function addStyle(string $name, string $value) {
        return $this->appendAttribute('style', "$name: $value;");
    }

    // END STYLE ATTRIBUTE

    public function setTabIndex($index) {
        return $this->setAttribute('tabindex', $index);
    }

    public function setXmlLang($lang) {
        return $this->setAttribute('xml:lang', $lang);
    }

    /*
     * END ATTRIBUTES
     */

    // TAG RELATIONSHIP

    public function appendTo(Tag $tag) {
        $tag->appendBody($this);
        return $this;
    }

    public function prependTo(Tag $tag) {
        $tag->prependBody($tag);
        return $this;
    }

}