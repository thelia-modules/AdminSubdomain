<?php
/*************************************************************************************/
/*      This file is part of the module AdminSubdomain.                              */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AdminSubdomain\EventListener;

use AdminSubdomain\AdminSubdomain;
use AdminSubdomain\Helper\ResponseHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Thelia\Core\HttpFoundation\Request;

/**
 * Class KernelResponseListener
 * @package AdminSubdomain\EventListener
 * @author Gilles Bourgeat <gilles@thelia.net>
 */
class KernelResponseListener implements EventSubscriberInterface
{
    /**
     * Handle response on KernelEvents::RESPONSE
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event A FilterResponseEvent object
     */
    public function addSubdomainInResponse(FilterResponseEvent $event)
    {
        /** @var Request $request */
        $request = $event->getRequest();

        $configSubdomain = AdminSubdomain::getConfigValue(AdminSubdomain::CONFIG_KEY_SUB_DOMAIN, null);

        if ($request->fromAdmin() && !empty($configSubdomain)) {
            /** @var Response $response */
            $response = $event->getResponse();

            if ($response->isRedirection()) {
                $response->setTargetUrl(
                    ResponseHelper::addSubdomain($request, $response->getTargetUrl(), $configSubdomain)
                );
            } else {
                $content = ResponseHelper::addSubdomain($request, $response->getContent(), $configSubdomain);
                $response->setContent($content);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => [
                ['addSubdomainInResponse', 32]
            ]
        ];
    }
}
