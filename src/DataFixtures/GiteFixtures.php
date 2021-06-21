<?php

namespace App\DataFixtures;

use App\Entity\Equipement;
use Faker;
use App\Entity\Gite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GiteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $equipements = [];
        $eq1  = new Equipement();
        $eq1->setName('Piscine');
        $eq2  = new Equipement();
        $eq2->setName('Sauna');
        $eq3  = new Equipement();
        $eq3->setName('Jardin');
        $eq4  = new Equipement();
        $eq4->setName('Lave linge');
        array_push($equipements, $eq1, $eq2, $eq3, $eq4);
        $manager->persist($eq1);
        $manager->persist($eq2);
        $manager->persist($eq3);
        $manager->persist($eq4);
        $manager->flush();

        for ($i = 0; $i <= 50; $i++) {
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
                ->addEquipement($faker->randomElement($equipements))
                ->setCreatedAt($faker->dateTimeThisYear('now', 'Europe/Paris'));
            $manager->persist($gite);
        }

        $manager->flush();
    }
}
