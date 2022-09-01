<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use DateTime;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ( $i=0; $i < 10; $i++) { 
            $event = new Event();
            $event
                ->setName(implode(' ', $faker->words($faker->numberBetween(1, 3))))
                ->setDescription($faker->text())
                ->setPrice($faker->numberBetween(10000, 15000))
                ->setCreatedAt($faker->dateTimeBetween('now', 'now'))
                ->setReleasedAt($faker->dateTimeBetween('now', '+4 week'))
                ->setFinishedAt($faker->dateTimeBetween('+4 week', '+2 month'))
                ->setImage((string) $faker->numberBetween(0, 3))
            ;
            $manager->persist($event);
        }

        $manager->flush();
    }
}
