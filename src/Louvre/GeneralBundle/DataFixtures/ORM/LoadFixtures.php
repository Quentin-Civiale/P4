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
        $objects = Fixtures::load(
            [
                __DIR__.'/users.yml',

            ],
            $manager,
            [
                'providers' => [$this],
            ]
        );

    }
}