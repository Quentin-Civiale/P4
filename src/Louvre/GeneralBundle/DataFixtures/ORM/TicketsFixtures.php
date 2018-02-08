<?php 

//namespace Louvre\GeneralBundle\DataFixtures\ORM;
//
//use Louvre\GeneralBundle\Entity\Tickets;
//use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Common\Persistence\ObjectManager;
//
//class TicketsFixtures extends Fixture
//{
//    public function load(ObjectManager $manager)
//    {
//        $ticket1 = new tickets();
//        $ticket1->setNom('Civiale');
//        $ticket1->setPrenom('Quentin');
//        $ticket1->setDateNaissance('20/05/1991');
//        $ticket1->setPrix('20');
//        $ticket1->setCommande($this->getReference('commande1'));
//        $manager->persist($ticket1);
//        
//        $ticket2 = new tickets();
//        $ticket2->setNom('TestNom');
//        $ticket2->setPrenom('TestPrenom');
//        $ticket2->setDateNaissance('20/05/1991');
//        $ticket2->setPrix('14');
//        $ticket2->setCommande($this->getReference('commande2'));
//        $manager->persist($ticket2);
//        
//        $manager->flush();
//        
//        $this->addReference('ticket1', $ticket1);
//        $this->addReference('ticket2', $ticket2);
//        
//    }
//    
//    
//    public function getOrder()
//    {
//        return 2;
//    }
//}
