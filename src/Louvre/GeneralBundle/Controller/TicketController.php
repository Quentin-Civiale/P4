<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Form\ticketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    public function ticketFormAction(Request $request)
    {
        //on crée un ticket
        $ticket = new Ticket();

        //on récupère le formulaire
        $form = $this->createForm(ticketType::class, $ticket);

        //requête lors de l'envoi du formulaire
        $form->handleRequest($request);
        //si le formulaire a été soumis
        if ($form->isSubmitted() && $form->isValid()) {
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
        return $this->render('ticket.html.twig', ['form' => $formView]);
    }
}
