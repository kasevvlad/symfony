<?php

namespace App\ResponseBuilder;

use App\Entity\Post;
use App\Factory\PostFactory;
use App\Resource\PostResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class Response
{
    public function __construct(
        private PostResource $postResource,
        private PostFactory $postFactory
    ){}

    public function toArrayFull(array $posts, int $status = 200, array $headers = [], bool $isJson = true): JsonResponse
    {
        $postOutputDTOs = $this->postFactory->makePostOutputDTOs($posts);
        $postResource = $this->postResource->postCollection($postOutputDTOs);
        return new JsonResponse($postResource, $status, $headers, $isJson); 
    }

    public function toArray(Post $post, int $status = 200, array $headers = [], bool $isJson = true): JsonResponse
    {
        $postOutputDTO = $this->postFactory->makePostOutputDTO($post);
        $postResource = $this->postResource->postItem($postOutputDTO);
        return new JsonResponse($postResource, $status, $headers, $isJson);
    }
}