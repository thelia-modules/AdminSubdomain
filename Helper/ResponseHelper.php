<?php
/*************************************************************************************/
/*      This file is part of the module AdminSubdomain.                              */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AdminSubdomain\Helper;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class ResponseHelper
 * @package AdminSubdomain\Helper
 * @author Gilles Bourgeat <gilles@thelia.net>
 */
class ResponseHelper
{
    /**
     * @param Request $request
     * @param string $content
     * @param string $subDomain
     * @return string
     */
    public static function addSubdomain(Request $request, $content, $subDomain)
    {
        $basePath = $request->getBasePath();
        $host = $request->getHost();

        $domain = RequestHelper::extractDomain($host);

        $content = preg_replace(
            '#\/[^\/]*\.?' . preg_quote($domain) . '(' . preg_quote($basePath) . '(?:\/index(?:_dev)?\.php)?\/(?:admin|assets\/backOffice|tinymce))#i',
            '/' . $subDomain . '.' . $domain . '$1',
            $content
        );

        return $content;
    }
}
