<?php
/**
 * Created by PhpStorm.
 * User: Stagiaire
 * Date: 02/04/2015
 * Time: 10:13
 */

namespace Aiconoa\StatisticsBundle\Service;

use Aiconoa\StatisticsBundle\Controller\DefaultController;
use Aiconoa\StatisticsBundle\Entity\Visit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class StatService {

    private $doctrine;
    private $controllerWhiteList;

    function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function addVisit(Request $request)
    {
        $em = $this->doctrine->getManager();

        $visit = new Visit();
        $visit->setPage($request->getUri());
        $visit->setIp($request->getClientIp());
        $visit->setDate(new \DateTime());

        $em->persist($visit);
        $em->flush();
    }

    public function setControllerWhiteList($whiteList)
    {
        $this->controllerWhiteList = $whiteList;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        foreach($this->controllerWhiteList as $wlController) {
            if($controller[0] instanceof $wlController) {
                $this->addVisit($event->getRequest());
                return;
            }
        }
    }

}