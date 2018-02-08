<?php

namespace Louvre\GeneralBundle\Controller;

use Louvre\GeneralBundle\Entity\Tickets;
use Louvre\GeneralBundle\Form\commandesType;
use Louvre\GeneralBundle\Form\ticketsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Louvre\GeneralBundle\Entity\Commandes;


class CommandesController extends Controller
{
    public function commandesFormulaireAction(Request $request)
    {
        //on crée une commande
        $commande = new Commandes();
        
        //on récupère le formulaire
        $form = $this->createForm(commandesType::class, $commande);
        
        //requête lors de l'envoi du formulaire
        $form->handleRequest($request);
        //si le formulaire a été soumis
        if($form->isSubmitted() && $form->isValid())
        {
            //on enregistre la commande en bdd
            $em = $this->getDoctrine()->getManager();
            //préparation à l'insertion dans la bdd
            $em->persist($commande);
            //envoi vers la bdd
            $em->flush();
            
            return new Response('Commande enregistrée !');
        }
        
        //on génère le html du formulaire
        $formView = $form->createView();
        
        //on rend la vue
        return $this->render('@General/Default/commandes.html.twig', array ('form' => $formView));
    }
    
    
    public function commandes_listAction()
    {
        $repository = $this->getDoctrine()->getRepository('GeneralBundle:Commandes');
        
        $commandes = $repository->findAll();
        
        return $this->render('@General/Default/commandesList.html.twig', array('commandes'=>$commandes));
    }
    
    public function editAction(Request $request, Commandes $commande)
    {
         //on récupère le formulaire
        $form = $this->createForm(commandesType::class, $commande);
        
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
        return $this->render('@General/Default/commandes.html.twig', array ('form' => $formView));
    }
    
    public function deleteAction(Commandes $commande)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();
        
        return new Response('Commande supprimée');
    }
    
}
