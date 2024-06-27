<?php

namespace App\Controller\Backend;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/users', name: 'admin.users')]
class UserController extends AbstractController
{
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(UserRepository $repo): Response
    {
        return $this->render('Backend/User/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }
}
