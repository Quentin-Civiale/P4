<?php

namespace Louvre\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller
{
    public function homeAction()
    {
//        $test2='test2';
//        var_dump($test2);

        return $this->render('@General/Default/index.html.twig');
    }
}
