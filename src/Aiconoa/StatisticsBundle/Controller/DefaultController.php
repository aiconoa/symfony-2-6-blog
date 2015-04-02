<?php

namespace Aiconoa\StatisticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/stats/")
     */
    public function indexAction()
    {
        $stats = $this->getDoctrine()->getRepository("AiconoaStatisticsBundle:Visit")->findNumberOfVisitsPerPage();

        return $this->render("AiconoaStatisticsBundle:Default:index.html.twig",
                                [
                                    "stats" => $stats
                                ]
        );
    }
}
