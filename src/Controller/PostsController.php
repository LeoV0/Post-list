<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\AddPostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostsController extends AbstractController
{
    /**
     * @Route("/posts", name="app_posts")
     */
    public function index(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Post::class);

        $posts=$repo->findBy([],['id'=>'DESC']);

        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
 * @Route("/posts/add", name="add_posts")
 */
public function add(Request $request, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(AddPostType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $entityManager->persist($data);
        $entityManager->flush();

        return $this->redirectToRoute('app_posts');
    }

    return $this->render('posts/add.html.twig', ['form' => $form->createView()]);
}

    /**
 * @Route("/posts/detail/{id}", name="detail_post")
 */
public function detail($id, PostRepository $repo): Response
{
    $post = $repo->find($id);
    return $this->render('posts/detail.html.twig', ['post' => $post]);
}
/**
 * @Route("/posts/modif/{id}", name="modif_post")
 */
public function modif($id, Request $request, PostRepository $repo, EntityManagerInterface $manager){
        $post=$repo->find($id);
        $form=$this->createForm(AddPostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('app_posts');
        }

        return $this->render('posts/modif.html.twig', ['form'=>$form->createView()]);


        
}

/**
 * @Route("/posts/delete/{id}", name="delete_post")
 */
public function delete($id, PostRepository $repo, EntityManagerInterface $manager): RedirectResponse
{
    $post = $repo->find($id);

    if (!$post) {
        throw $this->createNotFoundException('Post not found');
    }

    $manager->remove($post);
    $manager->flush();

    return $this->redirectToRoute('app_posts');
}

}