<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Form\loginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SecurityController extends Controller
{

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        dump($request);

        // obtention de l'erreur de connexion s'il y en a un
        $error = $authenticationUtils->getLastAuthenticationError();

        // dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(loginFormType::class, [
            '_username' => $lastUsername,
        ]);

        return $this->render('@General/Default/login.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
        ));

    }

    public function logoutAction()
    {
        throw new \Exception('This should not be reached!');
    }
}