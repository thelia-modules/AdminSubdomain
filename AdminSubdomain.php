<?php
/*************************************************************************************/
/*      This file is part of the module AdminSubdomain.                              */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AdminSubdomain;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Module\BaseModule;

/**
 * Class AdminSubdomain
 * @package AdminSubdomain
 * @author Gilles Bourgeat <gilles@thelia.net>
 */
class AdminSubdomain extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'adminsubdomain';

    const CONFIG_KEY_SUB_DOMAIN = 'sub_domain';
    const CONFIG_KEY_STRICT_MODE = 'strict_mode';

    /**
     * @param ConnectionInterface $con
     */
    public function postActivation(ConnectionInterface $con = null)
    {
        if (null === static::getConfigValue(static::CONFIG_KEY_SUB_DOMAIN)) {
            static::setConfigValue(static::CONFIG_KEY_SUB_DOMAIN, '');
        }

        if (null === static::getConfigValue(static::CONFIG_KEY_STRICT_MODE)) {
            static::setConfigValue(static::CONFIG_KEY_STRICT_MODE, 0);
        }
    }
}
