<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Genus;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
//        $genus = new Genus();
//        $genus->setName('Octopus'.rand(1, 100));
//        $genus->setSubFamily('Octopodinae');
//        $genus->setSpeciesCount(rand(100, 99999));
//        $manager->persist($genus);
//        $manager->flush();

        $objects = Fixtures::load(__DIR__.'/fixtures.yml', $manager);
    }
}