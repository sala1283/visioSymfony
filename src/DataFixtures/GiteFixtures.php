<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Gite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GiteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i <= 20; $i++) {
            $gite = new Gite();
            $gite
                ->setName($faker->word())
                ->setDescription($faker->text(100))
                ->setSurface($faker->numberBetween(80, 300))
                ->setBedrooms($faker->numberBetween(1, 5))
                ->setAddress($faker->address())
                ->setCity($faker->city())
                ->setPostaleCode($faker->postcode())
                ->setAnimals($faker->boolean())
                ->setCreatedAt($faker->dateTimeThisYear('now', 'Europe/Paris'));
            $manager->persist($gite);
        }

        $manager->flush();
    }
}
