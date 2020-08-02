<?php 
/**
 * @package    PHP Advanced API Guide
 * @author     Bermudez Steven
 * @copyright  2019 Bermudez
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

/**
 * Sanitize data which will be injected into SQL query
 *
 * @param string $string SQL data which will be injected into SQL query
 * @param bool $htmlOK Does data contain HTML code ? (optional)
 * @return string Sanitized data
 */
function pSQL($string, $htmlOK = false)
{
    return Db::getInstance()->escape($string, $htmlOK);
}

function bqSQL($string)
{
    return str_replace('`', '\`', pSQL($string));
}
