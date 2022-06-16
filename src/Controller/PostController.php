<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/addpost', name: 'addpost')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {

        $post = new Post;

        $form = $this->createForm(PostType::class, $post);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $post->setUser($this->getUser());
            $post->setCreatedAt(new DateTimeImmutable());
            $post->setUpdatedAt(new DateTimeImmutable());
            $post = $form->getData();

            // ... perform some action, such as saving the task to the database

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('addpost/index.html.twig', [
            'form' => $form,
        ]);
    }
}
