<?php 

namespace Louvre\GeneralBundle\DataFixtures\ORM;

use Louvre\GeneralBundle\Entity\Commandes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CommandesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $commande1 = new commandes();
        $commande1->getTickets(1);
        $commande1->setNom('Civiale');
        $commande1->setPrenom('Quentin');
        $commande1->setDate(new \DateTime());
        $commande1->setEmail('quentin.civiale@gmail.com');
        $commande1->setStatut('en cours');
        $manager->persist($commande1);
        
        $commande2 = new commandes();
        $commande2->getTickets(2);
        $commande2->setNom('TestCommandeNom');
        $commande2->setPrenom('TestCommandePrenom');
        $commande2->setDate(new \DateTime());
        $commande2->setEmail('test@test.com');
        $commande2->setStatut('validé');
        $manager->persist($commande2);
        
        $manager->flush();
        
        $this->addReference('commande1', $commande1);
        $this->addReference('commande2', $commande2);
        
    }
    
    
    public function getOrder()
    {
        return 1;
    }
}
