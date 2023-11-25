<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $authors = ['author1','author2','author3','author4','author5'];
        
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();

            $article->setTitle(substr($faker->sentence($nbWords = 6, $variableNbWords = true), 0, 255));
            $article->setDescription(substr($faker->paragraph($nbSentences = 3, $variableNbSentences = true), 0, 255));
            $randomAuthor = $authors[array_rand($authors)];
      
            $article->setAuthor($randomAuthor);


            $manager->persist($article);                             
        }

        $manager->flush();
    }
}
