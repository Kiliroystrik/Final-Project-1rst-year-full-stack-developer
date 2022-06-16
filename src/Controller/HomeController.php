<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(UserRepository $user, PostRepository $post): Response
    {

        $users = $user->findAll();
        $posts = $post->findAll();



        return $this->render('home/index.html.twig', [
            'controller_name' => 'home_controller',
            'users' => $users,
            'posts' => $posts,
        ]);
    }
}
