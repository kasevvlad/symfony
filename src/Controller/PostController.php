<?php

namespace App\Controller;

use App\Entity\Post;
use App\ResponseBuilder\PostResponseBuilder;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    public function __construct(
        private PostService $postService,
        private PostResponseBuilder $postResponseBuilder 
    ){}

    public function index(): JsonResponse
    {
        $posts = $this->postService->index();

        return $this->postResponseBuilder->toArrayFull($posts);
    }

    public function show(Post $post)
    {
        return $this->postResponseBuilder->toArray($post);
    }
}
