<?php

namespace Louvre\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfirmationController extends Controller
{
    public function confirmationAction()
    {
        return $this->render('@General/Default/confirmation.html.twig');
    }
}