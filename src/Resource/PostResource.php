<?php

namespace App\Resource;

use App\DTO\Output\Post\PostOutputDTO;
use Symfony\Component\Serializer\SerializerInterface;

class PostResource
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {
        
    }
    public function postItem(PostOutputDTO $postOutputDTO): string
    {
        return $this->serializer->serialize($postOutputDTO, 'json', ['groups' => ['post:item']]);
    }

    public function postCollection(array $posts): string
    {
        return $this->serializer->serialize($posts, 'json', ['groups' => ['post:item']]);
    }
}