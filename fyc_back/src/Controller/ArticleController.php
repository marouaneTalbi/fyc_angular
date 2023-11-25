<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Repository\StatsRepository;
use App\Repository\CommentRepository;
use App\Repository\AuthorRepository;




#[Route('/article')]
class ArticleController extends AbstractController
{
    private $articleRepository;
    private $statsRepository;
    private $commentRepository;
    private $authorRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        StatsRepository $statsRepository,
        CommentRepository $commentRepository,
        AuthorRepository $authorRepository
        )
    {
        $this->articleRepository = $articleRepository;
        $this->statsRepository = $statsRepository;
        $this->commentRepository = $commentRepository;
        $this->authorRepository = $authorRepository;

    }

    #[Route('/', name: 'article_index', methods: ['GET'])]
    public function index(): Response
    {
        $articles = $this->articleRepository->findAll();
        // Ici, adaptez le rendu selon votre besoin (par exemple, renvoyer un JSON)
        return $this->json($articles);
    }

    // #[Route('/{id}', name: 'article_show', methods: ['GET'])]
    #[Route('/{id}', name: 'article_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $article = $this->articleRepository->find($id);

        if (!$article) {
            throw $this->createNotFoundException('L\'article demandé n\'existe pas.');
        }

        // Ici, adaptez le rendu selon votre besoin
        return $this->json($article);
    }

    #[Route('/search', name: 'article_search', methods: ['GET'])]
    public function search(Request $request, ArticleRepository $repository): Response
    {
        $query = $request->query->get('search');
        $articles = $repository->findBySearchTerm($query);

        return $this->json($articles);
    }
    
    #[Route('/{id}/stats', name: 'article_stats', methods: ['GET'])]
    public function getArticleStats(int $id): Response
    {
        $stats = $this->statsRepository->findStatsByArticleId($id);

        if (!$stats) {
            return $this->json(['message' => 'Stats not found for the article.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($stats);
    }


    #[Route('/comments', name: 'article_comments', methods: ['GET'])]
    public function comments(): Response
    {
        $comments = $this->commentRepository->findAll();
        return $this->json($comments);
    }

    #[Route('/authors', name: 'article_autors', methods: ['GET'])]
    public function authors(): Response
    {
        $autors = $this->authorRepository->findAll();
        return $this->json($autors);
    }
}
