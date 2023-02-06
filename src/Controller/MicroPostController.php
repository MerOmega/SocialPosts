<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


//#[IsGranted("IS_AUTHENTICATED_FULLY")]
class MicroPostController extends AbstractController
{
    #[Route('/micro', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {

        /*
        $microPost = new MicroPost();
        $microPost -> setTitle("New2");
        $microPost -> setText("Some text");
        $microPost->setDate(new \DateTime());

        */
        /*
        $microPost = $posts->find("1");
        $microPost->setTitle("This changed");
        $posts->save($microPost,true);
        */
        //dd($posts->findAll());
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAllWithComments(),
        ]);
    }


    #[Route("/micro/{post}",name: "app_micro_post_show")]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function showOne(MicroPost $post):Response
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route("/micro/add",name:"app_micro_post_add",priority: 2)]
    #[IsGranted("ROLE_WRITER")]
    public function add(Request $request,MicroPostRepository $repository):Response
    {
        $microPost = new MicroPost();
        $form = $this->createForm(MicroPostType::class,$microPost);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $microPost = $form->getData();
            $microPost->setAuthor($this->getUser());
            $repository->save($microPost,true);

            $this->addFlash("success","Post Saved!");
            return $this->redirectToRoute("app_micro_post");
        }

        return $this->render(
            "micro_post/add.html.twig",
            [
                "form" =>$form
            ]
        );
    }

    #[Route("/micro/{post}/edit",name:"app_micro_post_edit",priority: 2)]
    #[IsGranted(MicroPost::EDIT,"post")]
    public function edit( MicroPost $post, Request $request,MicroPostRepository $repository):Response
    {
        $form = $this->createForm(MicroPostType::class,$post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $microPost = $form->getData();
            $repository->save($microPost,true);

            $this->addFlash("success","Post Saved!");
            return $this->redirectToRoute("app_micro_post");
        }

        return $this->render(
            "micro_post/edit.html.twig",
            [
                "form" =>$form
            ]
        );
    }

    #[Route("/micro/{post}/comment",name:"app_micro_post_comment",priority: 2)]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function addComment( MicroPost $post, Request $request,CommentRepository $repository):Response
    {
        $form = $this->createForm(CommentType::class,new Comment());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $repository->save($comment,true);

            $this->addFlash("success","Comment Saved!");
            return $this->redirectToRoute("app_micro_post_show",
                [
                    "post"=>$post->getId()
                ]
            );
        }

        return $this->render(
            "micro_post/comment.html.twig",
            [
                "form" =>$form,
                "post" => $post
            ]
        );
    }
}
