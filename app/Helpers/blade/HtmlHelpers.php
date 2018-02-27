<?php



/**
 * Convert an HTML string to entities.
 *
 * @param string $value
 *
 * @return string
 */
function IHEntities($value)
{
    return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
}

/**
 * Convert entities to HTML characters.
 *
 * @param string $value
 *
 * @return string
 */
function IHDecode($value)
{
    return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a link to a JavaScript file.
 *
 * @param string $url
 * @param array $attributes
 * @param bool $secure
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHScript($url, $attributes = [], $secure = null)
{
    $attributes['src'] =  IHUrlAsset($url, $secure);
    return IFToHtmlString('<script' . IFormAttributes($attributes) . '></script>' . PHP_EOL);
}

/**
 * Generate a link to a CSS file.
 *
 * @param string $url
 * @param array $attributes
 * @param bool $secure
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHStyle($url, $attributes = [], $secure = null)
{
    $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];
    $attributes = $attributes + $defaults;
    $attributes['href'] =  IHUrlAsset($url, $secure);
    return IFToHtmlString('<link' . IFormAttributes($attributes) . '>' . PHP_EOL);
}

/**
 * Generate an HTML image element.
 *
 * @param string $url
 * @param string $alt
 * @param array $attributes
 * @param bool $secure
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHImage($url, $alt = null, $attributes = [], $secure = null)
{
    $attributes['alt'] = $alt;
    return IFToHtmlString('<img src="' .  IHUrlAsset($url,
            $secure) . '"' . IFormAttributes($attributes) . '>');
}

/**
 * Generate a link to a Favicon file.
 *
 * @param string $url
 * @param array $attributes
 * @param bool $secure
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHFavicon($url, $attributes = [], $secure = null)
{
    $defaults = ['rel' => 'shortcut icon', 'type' => 'image/x-icon'];
    $attributes = $attributes + $defaults;
    $attributes['href'] =  IHUrlAsset($url, $secure);
    return IFToHtmlString('<link' . IFormAttributes($attributes) . '>' . PHP_EOL);
}

/**
 * Generate a HTML link.
 *
 * @param string $url
 * @param string $title
 * @param array $attributes
 * @param bool $secure
 * @param bool $escape
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHLink($url, $title = null, $attributes = [], $secure = null, $escape = true)
{
    $url = IUrlTo($url, [], $secure);
    if (is_null($title) || $title === false) {
        $title = $url;
    }
    if ($escape) {
        $title =  IEntities($title);
    }
    return IFToHtmlString('<a href="' . $url . '"' . IFormAttributes($attributes) . '>' . $title . '</a>');
}

/**
 * Generate a HTTPS HTML link.
 *
 * @param string $url
 * @param string $title
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHSecureLink($url, $title = null, $attributes = [])
{
    return  IHLink($url, $title, $attributes, true);
}

/**
 * Generate a HTML link to an asset.
 *
 * @param string $url
 * @param string $title
 * @param array $attributes
 * @param bool $secure
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHLinkAsset($url, $title = null, $attributes = [], $secure = null)
{
    $url =  IHUrlAsset($url, $secure);
    return  IHLink($url, $title ?: $url, $attributes, $secure);
}

/**
 * Generate a HTTPS HTML link to an asset.
 *
 * @param string $url
 * @param string $title
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHLinkSecureAsset($url, $title = null, $attributes = [])
{
    return  IHLinkAsset($url, $title, $attributes, true);
}

/**
 * Generate a HTML link to a named route.
 *
 * @param string $name
 * @param string $title
 * @param array $parameters
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHLinkRoute($name, $title = null, $parameters = [], $attributes = [])
{
    return  IHLink(IUrlRoute($name, $parameters), $title, $attributes);
}

/**
 * Generate a HTML link to a controller action.
 *
 * @param string $action
 * @param string $title
 * @param array $parameters
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHLinkAction($action, $title = null, $parameters = [], $attributes = [])
{
    return  IHLink( IUrlAction($action, $parameters), $title, $attributes);
}

/**
 * Generate a HTML link to an email address.
 *
 * @param string $email
 * @param string $title
 * @param array $attributes
 * @param bool $escape
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHMailto($email, $title = null, $attributes = [], $escape = true)
{
    $email =  IEmail($email);
    $title = $title ?: $email;
    if ($escape) {
        $title =  IEntities($title);
    }
    $email =  IObfuscate('mailto:') . $email;
    return IFToHtmlString('<a href="' . $email . '"' . IFormAttributes($attributes) . '>' . $title . '</a>');
}

/**
 * Obfuscate an e-mail address to prevent spam-bots from sniffing it.
 *
 * @param string $email
 *
 * @return string
 */
function IHEmail($email)
{
    return str_replace('@', '&#64;',  IObfuscate($email));
}

/**
 * Generates non-breaking space entities based on number supplied.
 *
 * @param int $num
 *
 * @return string
 */
function IHNbsp($num = 1)
{
    return str_repeat('&nbsp;', $num);
}

/**
 * Generate an ordered list of items.
 *
 * @param array $list
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString|string
 */
function IHOl($list, $attributes = [])
{
    return  IListing('ol', $list, $attributes);
}

/**
 * Generate an un-ordered list of items.
 *
 * @param array $list
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString|string
 */
function IHIl($list, $attributes = [])
{
    return  IListing('ul', $list, $attributes);
}

/**
 * Generate a description list of items.
 *
 * @param array $list
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHDl(array $list, array $attributes = [])
{
    $attributes = IFormAttributes($attributes);
    $html = "<dl{$attributes}>";
    foreach ($list as $key => $value) {
        $value = (array)$value;
        $html .= "<dt>$key</dt>";
        foreach ($value as $v_key => $v_value) {
            $html .= "<dd>$v_value</dd>";
        }
    }
    $html .= '</dl>';
    return IFToHtmlString($html);
}

/**
 * Create a listing HTML element.
 *
 * @param string $type
 * @param array $list
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString|string
 */
function IHListing($type, $list, $attributes = [])
{
    $html = '';
    if (count($list) == 0) {
        return $html;
    }
    // Essentially we will just spin through the list and build the list of the HTML
    // elements from the array. We will also handled nested lists in case that is
    // present in the array. Then we will build out the final listing elements.
    foreach ($list as $key => $value) {
        $html .= IListingElement($key, $type, $value);
    }
    $attributes = IFormAttributes($attributes);
    return IFToHtmlString("<{$type}{$attributes}>{$html}</{$type}>");
}

/**
 * Create the HTML for a listing element.
 *
 * @param mixed $key
 * @param string $type
 * @param mixed $value
 *
 * @return string
 */
function IHListingElement($key, $type, $value)
{
    if (is_array($value)) {
        return INestedListing($key, $type, $value);
    } else {
        return '<li>' . e($value) . '</li>';
    }
}

/**
 * Create the HTML for a nested listing attribute.
 *
 * @param mixed $key
 * @param string $type
 * @param mixed $value
 *
 * @return string
 */
function IHNestedListing($key, $type, $value)
{
    if (is_int($key)) {
        return  IListing($type, $value);
    } else {
        return '<li>' . $key .  IListing($type, $value) . '</li>';
    }
}

/**
 * Build a single attribute element.
 *
 * @param string $key
 * @param string $value
 *
 * @return string
 */
function IHAttributeElement($key, $value)
{
    // For numeric keys we will assume that the value is a boolean attribute
    // where the presence of the attribute represents a true value and the
    // absence represents a false value.
    // This will convert HTML attributes such as "required" to a correct
    // form instead of using incorrect numerics.
    if (is_numeric($key)) {
        return $value;
    }
    // Treat boolean attributes as HTML properties
    if (is_bool($value) && $key != 'value') {
        return $value ? $key : '';
    }
    if (!is_null($value)) {
        return $key . '="' . e($value) . '"';
    }
}

/**
 * Obfuscate a string to prevent spam-bots from sniffing it.
 *
 * @param string $value
 *
 * @return string
 */
function IHObfuscate($value)
{
    $safe = '';
    foreach (str_split($value) as $letter) {
        if (ord($letter) > 128) {
            return $letter;
        }
        // To properly obfuscate the value, we will randomly convert each letter to
        // its entity or hexadecimal representation, keeping a bot from sniffing
        // the randomly obfuscated letters out of the string on the responses.
        switch (rand(1, 3)) {
            case 1:
                $safe .= '&#' . ord($letter) . ';';
                break;
            case 2:
                $safe .= '&#x' . dechex(ord($letter)) . ';';
                break;
            case 3:
                $safe .= $letter;
        }
    }
    return $safe;
}

/**
 * Generate a meta tag.
 *
 * @param string $name
 * @param string $content
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHMeta($name, $content, array $attributes = [])
{
    $defaults = compact('name', 'content');
    $attributes = array_merge($defaults, $attributes);
    return IFToHtmlString('<meta' . IFormAttributes($attributes) . '>' . PHP_EOL);
}

/**
 * Generate an html tag.
 *
 * @param string $tag
 * @param mixed $content
 * @param array $attributes
 *
 * @return \Illuminate\Support\HtmlString
 */
function IHHTag($tag, $content, array $attributes = [])
{
    $content = is_array($content) ? implode(PHP_EOL, $content) : $content;
    return IFToHtmlString('<' . $tag . IFormAttributes($attributes) . '>' . PHP_EOL . IFToHtmlString($content) . PHP_EOL . '</' . $tag . '>' . PHP_EOL);
}