<?php

namespace Louvre\GeneralBundle\DataFixtures\ORM;

use Louvre\GeneralBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
//        $objects = Fixtures::load(__DIR__.'/fixtures.yml', $manager);

        $user = new User();
        $user->setEmail('quentin.civiale@gmail.com');

        $manager->persist($user);
        $manager->flush();

    }
}