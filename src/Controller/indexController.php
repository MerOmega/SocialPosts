<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use App\Repository\UserProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class indexController extends AbstractController {

    private array $messages = [
        ['message' => 'Hello', 'created' => '2022/06/12'],
        ['message' => 'Hi', 'created' => '2022/04/12'],
        ['message' => 'Bye!', 'created' => '2021/05/12']
  ];

    /*
     * @params UserProfileRepository $profiles
     * */
    #[Route('/',name:'app_index')]
    public function index(MicroPostRepository $posts, CommentRepository $comments):Response
    {
//        $post = new MicroPost();
//        $post->setTitle("Textext");
//        $post->setText("Texting");
//        $post->setDate(new DateTime());

//        $post = $posts->find(2);
//        $post->removeComment($post->getComments()[0]);
//        $posts->save($post,true);
//        $comment = new Comment();
//        $comment->setText("Thats cool too");
//        $comment->setPost($post);
//        //$post->addComment($comment);
//        $comments->save($comment,true);
        //        $user = new User();
//        $user->setEmail("test@test.com");
//        $user->setPassword("cinsaurralde");
//
//        $profile = new UserProfile();
//        $profile->setUser($user);
//        $profile->setName("Tesings");
//        $profile->setUsername("Testing");
//        $profiles->save($profile,true);
        return $this->render(
            "hello/index.html.twig",
            [
                "messages"=> $this->messages,
                "limit"=> 3,

            ]
        );
    }

    #[Route('/message/{id<\d+>}',name:'showone')]
    public function showOne(int $id):Response
    {
        return $this->render(
            'hello/showone.html.twig',
            [
                'message' => $this->messages[$id]
            ]
        );
        //return new Response($this->messages[$id]);
    }
}