<?php
/*************************************************************************************/
/*      This file is part of the module AdminSubdomain.                              */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AdminSubdomain\Helper;

/**
 * Class RequestHelper
 * @package AdminSubdomain\Helper
 * @author Gilles Bourgeat <gilles@thelia.net>
 */
class RequestHelper
{
    /**
     * @param string $string
     * @return string
     */
    public static function extractDomain($string)
    {
        $host = static::extractHost($string);

        if (preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $host, $matches)) {
            return $matches['domain'];
        }

        return $host;
    }

    /**
     * @param string $string
     * @return string
     */
    public static function extractSubdomain($string)
    {
        $domain = static::extractDomain($string);

        $host = static::extractHost($string);

        $subDomains = rtrim(strstr($host, $domain, true), '.');

        return $subDomains;
    }

    /**
     * @param string $string
     * @return null|string
     */
    public static function extractHost($string)
    {
        $parse = parse_url($string);

        if (isset($parse['host'])) {
            return $parse['host'];
        } elseif (isset($parse['path'])) {
            return $parse['path'];
        }

        return null;
    }
}
