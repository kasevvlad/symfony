<?php

namespace App\Factory;

use App\DTO\Input\Post\PostInputDTO;
use App\DTO\Output\Post\PostOutputDTO;
use App\Entity\Category;
use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class PostFactory
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
        
    }
    public function createPost(PostInputDTO $storePostInputDTO): Post
    {
        $post = new Post();
        $category = $this->em->getReference(Category::class, $storePostInputDTO->categoryId);

        $post->setTitle($storePostInputDTO->title);
        $post->setDescription($storePostInputDTO->description);
        $post->setContent($storePostInputDTO->content);
        $post->setPublishedAt($storePostInputDTO->publishedAt);
        $post->setStatus($storePostInputDTO->status);
        $post->setCategory($category);

        return $post;
    }

    public function editPost(Post $post, PostInputDTO $postInputDTO): Post
    {
        $category = $this->em->getReference(Category::class, $postInputDTO->categoryId);

        $post->setTitle($postInputDTO->title);
        $post->setDescription($postInputDTO->description);
        $post->setContent($postInputDTO->content);
        $post->setPublishedAt($postInputDTO->publishedAt);
        $post->setStatus($postInputDTO->status);
        $post->setCategory($category);

        return $post;
    }

    public function makePostInputDTO(array $data): PostInputDTO
    {
        $post = new PostInputDTO();

        $post->title = $data['title'] ?? null;
        $post->description = $data['description'] ?? null;
        $post->content = $data['content'] ?? null;
        $post->publishedAt = $data['publishedAt'] ? new DateTimeImmutable($data['publishedAt']) : null;
        $post->status = $data['status'] ?? null;
        $post->categoryId = $data['categoryId'] ?? null;

        return $post;
    }


    public function makePostOutputDTO(Post $post): PostOutputDTO
    {
        $postOutputDTO = new PostOutputDTO();

        $postOutputDTO->id = $post->getId();
        $postOutputDTO->title = $post->getTitle();
        $postOutputDTO->description = $post->getDescription();
        $postOutputDTO->content = $post->getContent();
        $postOutputDTO->publishedAt = $post->getPublishedAt();
        $postOutputDTO->status = $post->getStatus();
        $postOutputDTO->category = $post->getCategory();

        return $postOutputDTO;
    }

    public function makePostOutputDTOs(array $posts): array
    {
        return array_map(fn($post) => $this->makePostOutputDTO($post), $posts);
    }
}