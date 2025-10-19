<?php

namespace App\Resource;

use App\DTO\Output\PostOutputDTO;
use App\Entity\Post;
use Symfony\Component\Serializer\SerializerInterface;

class PostResource
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {
        
    }
    public function postItem(PostOutputDTO $postOutputDTO)
    {
        return $this->serializer->serialize($postOutputDTO, 'json', ['groups' => ['post:item']]);
    }
}