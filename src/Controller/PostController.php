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
        private PostFactory $postFactory,
        private PostDTOValidator $postDTOValidator
    ){}

    public function index(): JsonResponse
    {
        $posts = $this->postService->index();

        return $this->postResponseBuilder->toArrayFull($posts);
    }

    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $storePostInputDTO = $this->postFactory->makeStorePostDTO($data);

        $this->postDTOValidator->validate($storePostInputDTO);

        $post = $this->postService->store($storePostInputDTO);

        return $this->postResponseBuilder->storePost($post);
    }

    public function show(Post $post): JsonResponse
    {
        return $this->postResponseBuilder->toArray($post);
    }

    public function update(Request $request, Post $post)
    {
        $data = json_decode($request->getContent(), true);

        $updatePostInputDTO = $this->postFactory->makeUpdatePostDTO($data);
        $this->postDTOValidator->validate($updatePostInputDTO);

        $post = $this->postService->update($post, $updatePostInputDTO);

        return $this->postResponseBuilder->toArray($post);
    }
}
