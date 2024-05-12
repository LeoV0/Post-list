<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr_FR');
        for($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->setTitre($faker->words(5,true))
            ->setContenu($faker->realText(255));
            $manager->persist($post);
            
        }

        $manager->flush();
    }
}
