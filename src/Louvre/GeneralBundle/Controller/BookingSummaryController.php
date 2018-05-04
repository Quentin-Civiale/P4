<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Order;
use Louvre\GeneralBundle\Entity\Ticket;
use Louvre\GeneralBundle\Form\orderType;
use Louvre\GeneralBundle\Form\ticketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class OrderSummaryController extends Controller
{
    public function orderSummaryAction()
    {
        $repository = $this->getDoctrine()->getRepository('Order.php');
        
        $commandes = $repository->findAll();
        
        return $this->render('orderSummary.html.twig', array('commandes'=> $commandes));
    }
    
//    public function editAction(Request $request, Order $commande)
//    {
//         //on récupère le formulaire
//        $form = $this->createForm(orderType::class, $commande);
//
//        //requête lors de l'envoi du formulaire
//        $form->handleRequest($request);
//
//        //si le formulaire a été soumis
//        if($form->isSubmitted() && $form->isValid())
//        {
//            //on enregistre la commande en bdd
//            $em = $this->getDoctrine()->getManager();
//
//            //envoi vers la bdd
//            $em->flush();
//
//            return new Response('Order modifiée !');
//        }
//
//        //on génère le html du formulaire
//        $formView = $form->createView();
//
//        //on rend la vue
//        return $this->render('@General/Default/order.html.twig', array ('form' => $formView));
//    }
}
