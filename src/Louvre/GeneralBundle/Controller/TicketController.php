<?php

namespace Louvre\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Louvre\GeneralBundle\Entity\Tickets;
use Louvre\GeneralBundle\Form\ticketsType;


class TicketsController extends Controller
{
    public function ticketsFormulaireAction(Request $request)
    {
        //on crée un ticket
        $ticket = new Tickets();
        
        //on récupère le formulaire
        $form = $this->createForm(ticketsType::class, $ticket);
        
        //requête lors de l'envoi du formulaire
        $form->handleRequest($request);
        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid())
        {
            //on enregistre le ticket en bdd
            $em = $this->getDoctrine()->getManager();
            //préparation à l'insertion dans la bdd
            $em->persist($ticket);
            //envoi vers la bdd
            $em->flush();
            
            return new Response('Ticket enregistré !');
        }
        
        //on génère le html du formulaire
        $formView = $form->createView();
        
        //on rend la vue
        return $this->render('@General/Default/tickets.html.twig', array ('form' => $formView));
    }
    
}
