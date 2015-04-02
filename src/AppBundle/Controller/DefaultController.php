<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('Default/index.html.twig');
    }

    /**
     * @Route("/static-page")
     */
    public function staticPageAction()
    {
        return $this->render('Default/static-page.html.twig');
    }
}
