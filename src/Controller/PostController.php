<?php

namespace App\Controller;

use App\DTOValidator\PostDTOValidator;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\ResponseBuilder\PostResponseBuilder;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    public function __construct(
        private PostService $postService,
        private PostResponseBuilder $postResponseBuilder,
    ){}

    public function index(): JsonResponse
    {
        $posts = $this->postService->index();

        return $this->postResponseBuilder->toArrayFull($posts);
    }

    public function store(Request $request, PostFactory $postFactory, PostDTOValidator $postDTOValidator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $storePostInputDTO = $postFactory->makeStorePostDTO($data);

        $postDTOValidator->validate($storePostInputDTO);

        $post = $this->postService->store($storePostInputDTO);

        return $this->postResponseBuilder->storePost($post);
    }

    public function show(Post $post): JsonResponse
    {
        return $this->postResponseBuilder->toArray($post);
    }
}
