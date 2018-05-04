<?php

namespace Louvre\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TranslationController extends Controller
{
    public function translateAction($name)
    {
        return $this->render('@General/Default/translation.html.twig', array(
            'name' => $name
        ));
    }
}
