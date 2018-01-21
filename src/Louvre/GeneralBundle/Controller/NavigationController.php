<?php

namespace Louvre\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends Controller
{
    public function selectionAction()
    {
        return $this->render('@GeneralBundle/Default/index.html.twig');
    }
    
    public function recapAction()
    {
        return $this->render('@GeneralBundle/Default/index.html.twig');
    }
    
    public function paiementAction()
    {
        return $this->render('@GeneralBundle/Default/index.html.twig');
    }
    
    public function confirmationAction()
    {
        return $this->render('@GeneralBundle/Default/index.html.twig');
    }
}
