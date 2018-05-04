<?php

namespace Louvre\GeneralBundle\Controller;


use Louvre\GeneralBundle\Entity\User;
use Louvre\GeneralBundle\Form\UserRegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class UserController extends Controller
{
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserRegistrationFormType::class);

        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Bienvenue' .$user->getUsername());

//            return $this->redirectToRoute('selection');
            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('louvre.general.security.login_form_authenticator'),
                    'main'
            );
        }

        return $this->render('@General/Default/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}