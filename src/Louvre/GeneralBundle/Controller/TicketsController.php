<?php

namespace Louvre\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Louvre\GeneralBundle\Entity\Tickets;
use Louvre\GeneralBundle\Form\ticketsType;


class TicketsController extends Controller
{
    public function ajoutAction()
    {
//        $test3='test3';
//        var_dump($test3);
        
        $em = $this->getDoctrine()->getManager();
        
        $tickets = new Tickets();
        $tickets->setNom('Civiale');
        $tickets->setPrenom('Quentin');
        $tickets->setDateNaissance('20-05-1991');
        $tickets->setPrix('18.00');
        $tickets->setIdCommande('0001');
        
        $em->persist($tickets);
        $em->flush();
        
        $alltickets = $em->getRepository('GeneralBundle:Tickets')->findAll();
        
        return $this->render('@General/Default/tickets.html.twig', array('alltickets' => $alltickets));
    }
}
