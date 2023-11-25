<?php



namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Stats;

class StatsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $articleRepository = $manager->getRepository(Article::class);
        $articles = $articleRepository->findAll();

        foreach ($articles as $article) {
            $stats = new Stats();
            $stats->setArticle($article);
            $stats->setViews(rand(10, 100));
            $stats->setLikes(rand(0, 50));
            $stats->setShares(rand(0, 30));

            $manager->persist($stats);
        }

        $manager->flush();
    }
}