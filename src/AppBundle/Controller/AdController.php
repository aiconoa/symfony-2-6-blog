<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdController extends Controller
{

    public function adAction($width, $height, $color)
    {
        return $this->render('Ad/ad.html.twig',
            [
                "width" => $width,
                "height" => $height,
                "color" => $color
            ]
        );
    }

}
