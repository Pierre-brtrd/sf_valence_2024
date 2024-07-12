<?php

namespace App\Controller\Frontend;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/articles', name: 'app.articles')]
class ArticleController extends AbstractController
{
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(ArticleRepository $repo): Response
    {
        return $this->render('Frontend/Article/index.html.twig', [
            'articles' => $repo->findBy(["enable" => true], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/{id}', name: '.show', methods: ['GET'])]
    public function show(?Article $article): Response|RedirectResponse
    {
        if (!$article || !$article->isEnable()) {
            $this->addFlash('error', 'Article non trouvé');

            return $this->redirectToRoute('app.articles.index');
        }

        return $this->render('Frontend/Article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
