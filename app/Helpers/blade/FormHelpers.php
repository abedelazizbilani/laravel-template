<?php

/**
 * Transform the string to an Html serializable object
 *
 * @param $html
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFToHtmlString($html)
{
    return new \Illuminate\Support\HtmlString($html);
}

/**
 * Build an HTML attribute string from an array.
 *
 * @param array $attributes
 *
 * @return string
 */
function IFAttributes($attributes)
{
    $html = [];
    foreach ((array)$attributes as $key => $value) {
        $element = IHAttributeElement($key, $value);
        if (!is_null($element)) {
            $html[] = $element;
        }
    }
    return count($html) > 0 ? ' ' . implode(' ', $html) : '';
}

/**
 * Create a form field.
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFField($type, $name, $value = null, $errors, $options = [])
{
    $errorText = $errors->first($name, '<small class="help-block">:message</small>');
    $hasError = $errors->has($name) ? 'has-error' : "";
    return IFToHtmlString('<div class="form-group' . $hasError . '">'
        . IFLabel($name)
        . IFInput($type, $name, $value, $options)
        . $errorText
        . '</div>');
}


/**
 * Create a form label element.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 * @param  bool $escape_html
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFLabel($name, $value = null, $options = [], $escape_html = true)
{
    $options = IFAttributes($options);
    $value = $value ?: ucwords(str_replace('_', ' ', $name));
    return IFToHtmlString('<label for="' . $name . '"' . $options . '>' . trans($value) . '</label>');
}

/**
 * Format the label value.
 *
 * @param  string $name
 * @param  string|null $value
 *
 * @return string
 */
function IFFormatLabel($name, $value)
{
    return $value ?: ucwords(str_replace('_', ' ', $name));
}

/**
 * Create a form input field.
 *
 * @param  string $type
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFInput($type, $name, $value = null, $options = [])
{
    if (!isset($options['name'])) {
        $options['name'] = $name;
    }
    // We will get the appropriate value for the given field. We will look for the
    // value in the session for the value in the old input data then we'll look
    // in the model instance if one is set. Otherwise we will just use empty.
    $id = ideaGetIdAttribute($name, $options);
    if (!in_array($type, ['file', 'password', 'checkbox', 'radio'])) {
        $value = ideaGetValueAttribute($name, $value);
    }
    // Once we have the type, value, and ID we can merge them into the rest of the
    // attributes array so we can convert them into their HTML attribute format
    // when creating the HTML element. Then, we will return the entire input.
    $merge = compact('type', 'value', 'id');
    $options = array_merge($options, $merge);

    $options['class'] = !empty($options['class']) ? "form-control " . $options['class'] : "form-control";

    if (empty($options['id'])) {
        $options['id'] = $options['name'];
    }

    return IFToHtmlString('<input' . IFAttributes($options) . '>');
}

/**
 * Create a text input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFText($name, $value = null, $options = [])
{
    return IFInput('text', $name, $value, $options);
}

/**
 * Create a password input field.
 *
 * @param  string $name
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFPassword($name, $options = [])
{
    return IFInput('password', $name, '', $options);
}

/**
 * Create a hidden input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFHidden($name, $value = null, $options = [])
{
    return IFInput('hidden', $name, $value, $options);
}

/**
 * Create a search input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFSearch($name, $value = null, $options = [])
{
    return IFInput('search', $name, $value, $options);
}

/**
 * Create an e-mail input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFEmail($name, $value = null, $options = [])
{
    return IFInput('email', $name, $value, $options);
}

/**
 * Create a tel input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFTel($name, $value = null, $options = [])
{
    return IFInput('tel', $name, $value, $options);
}

/**
 * Create a number input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFNumber($name, $value = null, $options = [])
{
    return IFInput('number', $name, $value, $options);
}

/**
 * Create a date input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFDate($name, $value = null, $options = [])
{
    if ($value instanceof DateTime) {
        $value = $value->format('Y-m-d');
    }
    return IFInput('date', $name, $value, $options);
}

/**
 * Create a datetime input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFDatetime($name, $value = null, $options = [])
{
    if ($value instanceof DateTime) {
        $value = $value->format(DateTime::RFC3339);
    }
    return IFInput('datetime', $name, $value, $options);
}

/**
 * Create a datetime-local input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFDatetimeLocal($name, $value = null, $options = [])
{
    if ($value instanceof DateTime) {
        $value = $value->format('Y-m-d\TH:i');
    }
    return IFInput('datetime-local', $name, $value, $options);
}

/**
 * Create a time input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFTime($name, $value = null, $options = [])
{
    return IFInput('time', $name, $value, $options);
}

/**
 * Create a url input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFUrl($name, $value = null, $options = [])
{
    return IFInput('url', $name, $value, $options);
}

/**
 * Create a file input field.
 *
 * @param  string $name
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFFile($name, $options = [])
{
    return IFInput('file', $name, null, $options);
}

/**
 * Create a textarea input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function IFTextarea($name, $value = null, $options = [])
{
    if (!isset($options['name'])) {
        $options['name'] = $name;
    }
    // Next we will look for the rows and cols attributes, as each of these are put
    // on the textarea element definition. If they are not present, we will just
    // assume some sane default values for these attributes for the developer.
    $options = ideaSetTextAreaSize($options);
    $options['id'] = ideaGetIdAttribute($name, $options);
    $value = (string)ideaGetValueAttribute($name, $value);
    unset($options['size']);
    // Next we will convert the attributes into a string form. Also we have removed
    // the size attribute, as it was merely a short-cut for the rows and cols on
    // the element. Then we'll create the final textarea elements HTML for us.
    $options = IFAttributes($options);
    return IFToHtmlString('<textarea' . $options . '>' . e($value) . '</textarea>');
}

/**
 * Get the ID attribute for a field name.
 *
 * @param  string $name
 * @param  array $attributes
 *
 * @return string
 */
function ideaGetIdAttribute($name, $attributes, $labels = [])
{
    if (array_key_exists('id', $attributes)) {
        return $attributes['id'];
    }
    if (in_array($name, $labels)) {
        return $name;
    }
}


/**
 * Get the value that should be assigned to the field.
 *
 * @param  string $name
 * @param  string $value
 *
 * @return mixed
 */
function ideaGetValueAttribute($name, $value = null)
{
    if (is_null($name)) {
        return $value;
    }

    $request = request($name);
    if (!is_null($request)) {
        return $request;
    }
    if (!is_null($value)) {
        return $value;
    }
}

/**
 * Set the text area size on the attributes.
 *
 * @param  array $options
 *
 * @return array
 */
function ideaSetTextAreaSize($options)
{
    if (isset($options['size'])) {

        $segments = explode('x', $options['size']);
        return array_merge($options, ['cols' => $segments[0], 'rows' => $segments[1]]);
    }
    // If the "size" attribute was not specified, we will just look for the regular
    // columns and rows attributes, using sane defaults if these do not exist on
    // the attributes array. We'll then return this entire options array back.
    $cols = array_get($options, 'cols', 50);
    $rows = array_get($options, 'rows', 10);
    return array_merge($options, compact('cols', 'rows'));
}


/**
 * Create a select box field.
 *
 * @param  string $name
 * @param  array  $list
 * @param  string $selected
 * @param  array  $selectAttributes
 * @param  array  $optionsAttributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function select(
    $name,
    $list = [],
    $selected = null,
    array $selectAttributes = [],
    array $optionsAttributes = []
) {
    $this->type = 'select';
    // When building a select box the "value" attribute is really the selected one
    // so we will use that when checking the model or session for a value which
    // should provide a convenient method of re-populating the forms on post.
    $selected = ideaGetValueAttribute($name, $selected);
    $selectAttributes['id'] = $this->getIdAttribute($name, $selectAttributes);
    if (! isset($selectAttributes['name'])) {
        $selectAttributes['name'] = $name;
    }
    // We will simply loop through the options and build an HTML value for each of
    // them until we have an array of HTML declarations. Then we will join them
    // all together into one single HTML element that can be put on the form.
    $html = [];
    if (isset($selectAttributes['placeholder'])) {
        $html[] = $this->placeholderOption($selectAttributes['placeholder'], $selected);
        unset($selectAttributes['placeholder']);
    }
    foreach ($list as $value => $display) {
        $optionAttributes = isset($optionsAttributes[$value]) ? $optionsAttributes[$value] : [];
        $html[] = $this->getSelectOption($display, $value, $selected, $optionAttributes);
    }
    // Once we have all of this HTML, we can join this into a single element after
    // formatting the attributes into an HTML "attributes" string, then we will
    // build out a final select statement, which will contain all the values.
    $selectAttributes = IFAttributes($selectAttributes);
    $list = implode('', $html);
    return IFToHtmlString("<select{$selectAttributes}>{$list}</select>");
}
/**
 * Create a select range field.
 *
 * @param  string $name
 * @param  string $begin
 * @param  string $end
 * @param  string $selected
 * @param  array  $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function selectRange($name, $begin, $end, $selected = null, $options = [])
{
    $range = array_combine($range = range($begin, $end), $range);
    return $this->select($name, $range, $selected, $options);
}
/**
 * Create a select year field.
 *
 * @param  string $name
 * @param  string $begin
 * @param  string $end
 * @param  string $selected
 * @param  array  $options
 *
 * @return mixed
 */
function selectYear()
{
    return call_user_func_array([$this, 'selectRange'], func_get_args());
}
/**
 * Create a select month field.
 *
 * @param  string $name
 * @param  string $selected
 * @param  array  $options
 * @param  string $format
 *
 * @return \Illuminate\Support\HtmlString
 */
function selectMonth($name, $selected = null, $options = [], $format = '%B')
{
    $months = [];
    foreach (range(1, 12) as $month) {
        $months[$month] = strftime($format, mktime(0, 0, 0, $month, 1));
    }
    return $this->select($name, $months, $selected, $options);
}
/**
 * Get the select option for the given value.
 *
 * @param  string $display
 * @param  string $value
 * @param  string $selected
 * @param  array  $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function getSelectOption($display, $value, $selected, array $attributes = [])
{
    if (is_array($display)) {
        return $this->optionGroup($display, $value, $selected, $attributes);
    }
    return $this->option($display, $value, $selected, $attributes);
}
/**
 * Create an option group form element.
 *
 * @param  array  $list
 * @param  string $label
 * @param  string $selected
 * @param  array  $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function optionGroup($list, $label, $selected, array $attributes = [])
{
    $html = [];
    foreach ($list as $value => $display) {
        $html[] = $this->option($display, $value, $selected, $attributes);
    }
    return IFToHtmlString('<optgroup label="' . e($label) . '">' . implode('', $html) . '</optgroup>');
}
/**
 * Create a select element option.
 *
 * @param  string $display
 * @param  string $value
 * @param  string $selected
 * @param  array  $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function option($display, $value, $selected, array $attributes = [])
{
    $selected = $this->getSelectedValue($value, $selected);
    $options = ['value' => $value, 'selected' => $selected] + $attributes;
    return IFToHtmlString('<option' . IFAttributes($options) . '>' . e($display) . '</option>');
}
/**
 * Create a placeholder select element option.
 *
 * @param $display
 * @param $selected
 *
 * @return \Illuminate\Support\HtmlString
 */
function placeholderOption($display, $selected)
{
    $selected = $this->getSelectedValue(null, $selected);
    $options = [
        'selected' => $selected,
        'value' => '',
    ];
    return IFToHtmlString('<option' . IFAttributes($options) . '>' . e($display) . '</option>');
}
/**
 * Determine if the value is selected.
 *
 * @param  string $value
 * @param  string $selected
 *
 * @return null|string
 */
function getSelectedValue($value, $selected)
{
    if (is_array($selected)) {
        return in_array($value, $selected, true) || in_array((string) $value, $selected, true) ? 'selected' : null;
    } elseif ($selected instanceof Collection) {
        return $selected->contains($value) ? 'selected' : null;
    }
    return ((string) $value == (string) $selected) ? 'selected' : null;
}
/**
 * Create a checkbox input field.
 *
 * @param  string $name
 * @param  mixed  $value
 * @param  bool   $checked
 * @param  array  $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function checkbox($name, $value = 1, $checked = null, $options = [])
{
    return $this->checkable('checkbox', $name, $value, $checked, $options);
}
/**
 * Create a radio button input field.
 *
 * @param  string $name
 * @param  mixed  $value
 * @param  bool   $checked
 * @param  array  $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function radio($name, $value = null, $checked = null, $options = [])
{
    if (is_null($value)) {
        $value = $name;
    }
    return $this->checkable('radio', $name, $value, $checked, $options);
}
/**
 * Create a checkable input field.
 *
 * @param  string $type
 * @param  string $name
 * @param  mixed  $value
 * @param  bool   $checked
 * @param  array  $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function checkable($type, $name, $value, $checked, $options)
{
    $this->type = $type;
    $checked = $this->getCheckedState($type, $name, $value, $checked);
    if ($checked) {
        $options['checked'] = 'checked';
    }
    return IFInput($type, $name, $value, $options);
}
/**
 * Get the check state for a checkable input.
 *
 * @param  string $type
 * @param  string $name
 * @param  mixed  $value
 * @param  bool   $checked
 *
 * @return bool
 */
function getCheckedState($type, $name, $value, $checked)
{
    switch ($type) {
        case 'checkbox':
            return $this->getCheckboxCheckedState($name, $value, $checked);
        case 'radio':
            return $this->getRadioCheckedState($name, $value, $checked);
        default:
            return ideaGetValueAttribute($name) == $value;
    }
}
/**
 * Get the check state for a checkbox input.
 *
 * @param  string $name
 * @param  mixed  $value
 * @param  bool   $checked
 *
 * @return bool
 */
function getCheckboxCheckedState($name, $value, $checked)
{
    $request = $this->request($name);
    if (isset($this->session) && ! $this->oldInputIsEmpty() && is_null($this->old($name)) && !$request) {
        return false;
    }
    if ($this->missingOldAndModel($name) && !$request) {
        return $checked;
    }
    $posted = ideaGetValueAttribute($name, $checked);
    if (is_array($posted)) {
        return in_array($value, $posted);
    } elseif ($posted instanceof Collection) {
        return $posted->contains('id', $value);
    } else {
        return (bool) $posted;
    }
}
/**
 * Get the check state for a radio input.
 *
 * @param  string $name
 * @param  mixed  $value
 * @param  bool   $checked
 *
 * @return bool
 */
function getRadioCheckedState($name, $value, $checked)
{
    $request = request($name);
    if ($this->missingOldAndModel($name) && !$request) {
        return $checked;
    }
    return ideaGetValueAttribute($name) == $value;
}

/**
 * Create a HTML reset input element.
 *
 * @param  string $value
 * @param  array  $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function reset($value, $attributes = [])
{
    return IFInput('reset', null, $value, $attributes);
}
/**
 * Create a HTML image input element.
 *
 * @param  string $url
 * @param  string $name
 * @param  array  $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function image($url, $name = null, $attributes = [])
{
    $attributes['src'] = $this->url->asset($url);
    return IFInput('image', $name, null, $attributes);
}
/**
 * Create a color input field.
 *
 * @param  string $name
 * @param  string $value
 * @param  array  $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function color($name, $value = null, $options = [])
{
    return IFInput('color', $name, $value, $options);
}
/**
 * Create a submit button element.
 *
 * @param  string $value
 * @param  array  $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function submit($value = null, $options = [])
{
    return IFInput('submit', null, $value, $options);
}
/**
 * Create a button element.
 *
 * @param  string $value
 * @param  array  $options
 *
 * @return \Illuminate\Support\HtmlString
 */
function button($value = null, $options = [])
{
    if (! array_key_exists('type', $options)) {
        $options['type'] = 'button';
    }
    return IFToHtmlString('<button' . IFAttributes($options) . '>' . $value . '</button>');
}