<?php

namespace App\Controller;

use App\DTOValidator\PostDTOValidator;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\ResponseBuilder\Response;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class PostController extends AbstractController
{
    public function __construct(
        private PostService $postService,
        private Response $response,
        private PostFactory $postFactory,
        private PostDTOValidator $postDTOValidator
    ){}

    public function index(): JsonResponse
    {
        $posts = $this->postService->index();

        return $this->response->toArrayFull($posts);
    }

    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $postInputDTO = $this->postFactory->makePostInputDTO($data);
        $this->postDTOValidator->validate($postInputDTO);
        $post = $this->postService->store($postInputDTO);

        return $this->response->toArray($post);
    }

    public function show(Post $post): JsonResponse
    {
        return $this->response->toArray($post);
    }

    public function update(Request $request, Post $post)
    {
        $data = json_decode($request->getContent(), true);

        $updatePostInputDTO = $this->postFactory->makePostInputDTO($data);
        $this->postDTOValidator->validate($updatePostInputDTO);
        $post = $this->postService->update($post, $updatePostInputDTO);

        return $this->response->toArray($post);
    }

    public function destroy(Post $post)
    {
        $this->postService->delete($post);

        return new JsonResponse(null, 200);
    }
}
