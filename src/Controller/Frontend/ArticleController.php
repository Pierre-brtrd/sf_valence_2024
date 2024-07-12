<?php

namespace App\Controller\Frontend;

use App\Entity\Article;
use App\Filter\ArticleFilter;
use App\Form\ArticleFilterType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/articles', name: 'app.articles')]
class ArticleController extends AbstractController
{
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(ArticleRepository $repo, Request $request): Response
    {
        $articleFilter = new ArticleFilter;

        $form = $this->createForm(ArticleFilterType::class, $articleFilter);
        $form->handleRequest($request);

        $articles = $repo->findFilterArticle($articleFilter);

        return $this->render('Frontend/Article/index.html.twig', [
            'articles' => $articles,
            'form' => $form,
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
