<?php
/*************************************************************************************/
/*      This file is part of the module AdminSubdomain.                              */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AdminSubdomain\EventListener;

use AdminSubdomain\AdminSubdomain;
use AdminSubdomain\Helper\RequestHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RequestContext;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\HttpKernel\Exception\RedirectException;

/**
 * Class KernelControllerListener
 * @package AdminSubdomain\EventListener
 * @author Gilles Bourgeat <gilles@thelia.net>
 */
class KernelControllerListener implements EventSubscriberInterface
{
    /** @var ContainerInterface */
    protected $container;

    /**
     * KernelControllerListener constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function kernelController(FilterControllerEvent $event)
    {
        /** @var Request $request */
        $request = $event->getRequest();

        $configSubdomain = AdminSubdomain::getConfigValue(AdminSubdomain::CONFIG_KEY_SUB_DOMAIN, null);

        if (!empty($configSubdomain)) {
            $currentSubdomain = RequestHelper::extractSubdomain($request->getHost());
            $strictMode = (bool) AdminSubdomain::getConfigValue(AdminSubdomain::CONFIG_KEY_STRICT_MODE, false);

            if ($configSubdomain === $currentSubdomain) {
                if ($request->getPathInfo() === '/') {
                    throw new RedirectException($request->getBasePath() . '/admin');
                }

                $this->overrideSingletonUrl($request);

                if (!$request->fromAdmin() && $strictMode) {
                    $this->generateAdminPageNoteFound($request, $event);
                }
                return;
            }

            if (false !== $strictMode && $request->fromAdmin()) {
                throw new NotFoundHttpException();
            }
        }
    }

    /**
     * @param Request $request
     * @param FilterControllerEvent $event
     */
    protected function generateAdminPageNoteFound(Request $request, FilterControllerEvent $event)
    {
        $request->attributes->set('template', "404");
        $controller = new BaseAdminController();
        $controller->setContainer($this->container);
        $event->setController([$controller, 'processTemplateAction']);
    }

    /**
     * @param Request $request
     */
    protected function overrideSingletonUrl($request)
    {
        /** @var RequestContext $requestContext */
        $requestContext = $this->container->get('router.admin')->getContext();
        $requestContext->setHost(RequestHelper::extractDomain($request->getHost()));
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['kernelController', 256]
        ];
    }
}
