<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function index(Request $request,MicroPost $post, MicroPostRepository $postRepository): Response
    {
        $currentUser = $this->getUser();
        $post->addLikedBy($currentUser);
        $postRepository->save($post,true);
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/dislike/{id}', name: 'app_dislike')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function dislike(Request $request,MicroPost $post, MicroPostRepository $postRepository): Response
    {
        $currentUser = $this->getUser();
        $post->removeLikedBy($currentUser);
        $postRepository->save($post,true);
        return $this->redirect($request->headers->get("referer"));
    }
}
