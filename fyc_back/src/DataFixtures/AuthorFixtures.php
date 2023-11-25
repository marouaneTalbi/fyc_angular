<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Author;
use Faker\Factory;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $authors = ['author1','author2','author3','author4','author5'];
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $author = new Author();

            $randomAuthor = $authors[array_rand($authors)];
            $author->setName($randomAuthor);

            $manager->persist($author);                             
        }

        $manager->flush();
    }
}