<?php

namespace App\Factory;

use App\DTO\Input\StorePostInputDTO;
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

    public function makeStorePostDTO(array $data): StorePostInputDTO
    {
        $post = new StorePostInputDTO();

        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->content = $data['content'];
        $post->publishedAt = new DateTimeImmutable($data['published_at']);
        $post->status = $data['status'];
        $post->categoryId = $data['category_id'];

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