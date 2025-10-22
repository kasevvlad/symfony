<?php

namespace App\Factory;

use App\DTO\Input\StorePostInputDTO;
use App\DTO\Input\UpdatePostInputDTO;
use App\DTO\Output\PostOutputDTO;
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
    public function makePost(StorePostInputDTO $storePostInputDTO): Post
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

    public function editPost(Post $post, UpdatePostInputDTO $updatePostInputDTO): Post
    {
        $category = $this->em->getReference(Category::class, $updatePostInputDTO->categoryId);

        $post->setTitle($updatePostInputDTO->title);
        $post->setDescription($updatePostInputDTO->description);
        $post->setContent($updatePostInputDTO->content);
        $post->setPublishedAt($updatePostInputDTO->publishedAt);
        $post->setStatus($updatePostInputDTO->status);
        $post->setCategory($category);

        return $post;
    }

    public function makeStorePostDTO(array $data): StorePostInputDTO
    {
        $post = new StorePostInputDTO();

        $post->title = $data['title'] ?? null;
        $post->description = $data['description'] ?? null;
        $post->content = $data['content'] ?? null;
        $post->publishedAt = $data['publishedAt'] ? new DateTimeImmutable($data['publishedAt']) : null;
        $post->status = $data['status'] ?? null;
        $post->categoryId = $data['categoryId'] ?? null;

        return $post;
    }

    public function makeUpdatePostDTO(array $data): UpdatePostInputDTO
    {
        $post = new UpdatePostInputDTO();

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