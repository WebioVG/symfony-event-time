<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ( $i=0; $i < 10; $i++) { 
            $event = new Event();
            $event
                ->setName(implode(' ', $faker->words($faker->numberBetween(1, 3))))
                ->setDescription($faker->text())
                ->setPrice($faker->numberBetween(10000, 15000))
                ->setCreatedAt($faker->dateTimeBetween('now', 'now'))
                ->setReleasedAt($date = $faker->dateTimeBetween('-10 days', '+2 week'))
                ->setFinishedAt($date->modify('+'.rand(1, 5).' days'))
                ->setImage('/uploads/'.$faker->numberBetween(0, 5).'.png')
            ;
            $manager->persist($event);
        }

        $manager->flush();
    }
}
