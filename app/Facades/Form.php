<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Form extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'form';
    }

    public static function open($options = [])
    {
        $method = $options['method'] ?? 'POST';
        $url = $options['url'] ?? '#';
        $id = $options['id'] ?? '';

        $methodHtml = strtoupper($method) === 'GET' ? 'GET' : 'POST';

        $idAttr = $id ? "id=\"$id\"" : '';

        $html = "<form action=\"$url\" method=\"$methodHtml\" $idAttr>";

        if (!in_array(strtoupper($method), ['GET', 'POST'])) {
            $html .= '<input type="hidden" name="_method" value="' . htmlspecialchars($method, ENT_QUOTES) . '">';
        }

        return $html;
    }

    public static function close()
    {
        return '</form>';
    }

    public static function checkbox($name, $value = 1, $checked = false, $options = [])
    {
        if ($value === false || $value === null) {
            $value = '1';
        }

        $checkedAttr = $checked ? 'checked' : '';

        $attrs = '';
        foreach ($options as $key => $val) {
            $attrs .= ' ' . $key . '="' . htmlspecialchars($val, ENT_QUOTES) . '"';
        }

        $valueAttr = htmlspecialchars($value, ENT_QUOTES);

        return "<input type=\"checkbox\" name=\"$name\" value=\"$valueAttr\" $checkedAttr $attrs>";
    }


    public static function select($name, $options = [], $selected = null, $attributes = [])
    {
        if (isset($attributes['disabled']) && $attributes['disabled'] == false) {
            unset($attributes['disabled']);
        }

        $attrs = '';
        foreach ($attributes as $key => $val) {
            $attrs .= ' ' . $key . '="' . htmlspecialchars($val, ENT_QUOTES) . '"';
        }

        $html = "<select name=\"" . htmlspecialchars($name, ENT_QUOTES) . "\" $attrs>";

        if (isset($attributes['placeholder'])) {
            $placeholder = htmlspecialchars($attributes['placeholder'], ENT_QUOTES);
            $isSelected = ($selected === null || $selected === '') ? 'selected' : '';
            $html .= "<option value=\"\" $isSelected>$placeholder</option>";
        }

        foreach ($options as $value => $label) {
            if (is_array($label)) {
                // ini optgroup
                $html .= '<optgroup label="' . htmlspecialchars($value, ENT_QUOTES) . '">';
                foreach ($label as $subValue => $subLabel) {
                    $isSelected = (is_array($selected) && in_array($subValue, $selected)) || $subValue == $selected ? 'selected' : '';
                    $html .= '<option value="' . htmlspecialchars($subValue, ENT_QUOTES) . "\" $isSelected>" . htmlspecialchars($subLabel, ENT_QUOTES) . '</option>';
                }
                $html .= '</optgroup>';
            } else {
                // ini option biasa
                $isSelected = (is_array($selected) && in_array($value, $selected)) || $value == $selected ? 'selected' : '';
                $html .= '<option value="' . htmlspecialchars($value, ENT_QUOTES) . "\" $isSelected>" . htmlspecialchars($label, ENT_QUOTES) . '</option>';
            }
        }

        $html .= '</select>';

        return $html;
    }

    public static function textarea($name, $value = '', $attributes = [])
    {
        $attrs = '';
        foreach ($attributes as $key => $val) {
            $attrs .= ' ' . $key . '="' . htmlspecialchars($val, ENT_QUOTES) . '"';
        }

        return '<textarea name="' . htmlspecialchars($name, ENT_QUOTES) . '"' . $attrs . '>'
            . htmlspecialchars($value) .
            '</textarea>';
    }

    public static function label($for, $text, $attributes = [])
    {
        $attrs = '';
        $hasRequired = false;

        foreach ($attributes as $key => $val) {
            $attrs .= ' ' . $key . '="' . htmlspecialchars($val, ENT_QUOTES) . '"';
            if (strtolower($key) === 'required') {
                $hasRequired = true;
            }
        }

        $requiredMark = $hasRequired ? ' <span class="text-danger">*</span>' : '';

        return '<label for="' . htmlspecialchars($for, ENT_QUOTES) . '"' . $attrs . '>'
            . htmlspecialchars($text) . $requiredMark .
            '</label>';
    }

    public static function number($name, $value = '', $attributes = [])
    {
        $attrs = 'name="' . htmlspecialchars($name, ENT_QUOTES) . '" type="number"';
        if ($value !== null) {
            $attrs .= ' value="' . htmlspecialchars($value, ENT_QUOTES) . '"';
        }
        foreach ($attributes as $key => $val) {
            $attrs .= ' ' . $key . '="' . htmlspecialchars($val, ENT_QUOTES) . '"';
        }
        return '<input ' . $attrs . '>';
    }

    public static function hidden($name, $value = null, $attributes = [])
    {
        $attrs = 'name="' . htmlspecialchars($name, ENT_QUOTES) . '" type="hidden"';
        if ($value !== null) {
            $attrs .= ' value="' . htmlspecialchars($value, ENT_QUOTES) . '"';
        }
        foreach ($attributes as $key => $val) {
            $attrs .= ' ' . $key . '="' . htmlspecialchars($val, ENT_QUOTES) . '"';
        }
        return '<input ' . $attrs . '>';
    }

    public static function password($name, $attributes = [])
    {
        $attr = self::htmlAttributes($attributes);
        return "<input type=\"password\" name=\"$name\" $attr />";
    }

    protected static function htmlAttributes($attributes)
    {
        $html = [];
        foreach ($attributes as $key => $value) {
            $html[] = $key . '="' . htmlspecialchars($value, ENT_QUOTES) . '"';
        }
        return implode(' ', $html);
    }

    public static function text($name, $value = '', $attributes = [])
    {
        $attr = self::htmlAttributes($attributes);
        return "<input type=\"text\" name=\"$name\" value=\"" . htmlspecialchars($value, ENT_QUOTES) . "\" $attr />";
    }

    public static function date($name, $value = null, $options = [])
    {
        $optionsString = '';
        foreach ($options as $key => $val) {
            $optionsString .= " $key=\"$val\"";
        }
        $valueAttr = $value ? "value=\"$value\"" : '';
        return "<input type=\"date\" name=\"$name\" $valueAttr $optionsString>";
    }

    public static function radio($name, $value, $checked = false, $attributes = [])
    {
        $checkedAttr = $checked ? 'checked' : '';
        $attrs = self::htmlAttributes($attributes);
        $valueAttr = htmlspecialchars($value, ENT_QUOTES);

        return "<input type=\"radio\" name=\"$name\" value=\"$valueAttr\" $checkedAttr $attrs>";
    }

}
