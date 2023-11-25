<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Comment;
use Faker\Factory;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $comment = new Comment();
            $comment->setContent(substr($faker->paragraph($nbSentences = 3, $variableNbSentences = true), 0, 255));
            $manager->persist($comment);                             
        }

        $manager->flush();
    }
}