<?php

namespace Louvre\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends Controller
{
    public function accueilAction()
    {
//        $test2='test2';
//        var_dump($test2);
        
        return $this->render('@General/Default/index.html.twig');
    }
    
}
