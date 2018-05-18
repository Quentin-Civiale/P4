<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Booking;
use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Form\bookingType;
use Louvre\GeneralBundle\Form\ticketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class BookingSummaryController extends Controller
{
    public function bookingSummaryAction()
    {
        $repository = $this->getDoctrine()->getRepository('GeneralBundle:Booking');

        $booking = $repository->findAll();

        return $this->render('@General/Default/bookingSummary.html.twig', array('booking'=> $booking));
    }
    
    public function editAction(Request $request, Booking $booking)
    {
         //on récupère le formulaire
        $form = $this->createForm(bookingType::class, $booking);

        //requête lors de l'envoi du formulaire
        $form->handleRequest($request);

        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid())
        {
            //on enregistre la commande en bdd
            $em = $this->getDoctrine()->getManager();

            //envoi vers la bdd
            $em->flush();

            return new Response('Commande modifiée !');
        }

        //on génère le html du formulaire
        $formView = $form->createView();

        //on rend la vue
        return $this->render('@General/Default/booking.html.twig', array ('form' => $formView));
    }
}
