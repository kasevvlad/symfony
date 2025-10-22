<?php

namespace App\Service;

use App\DTO\Input\Post\PostInputDTO;
use App\DTO\Input\StorePostInputDTO;
use App\DTO\Input\UpdatePostInputDTO;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    public function __construct(
        private PostRepository $postRepository,
        private PostFactory $postFactory
    ){}

    public function index(): array
    {
        return $this->postRepository->findAll();
    }

    public function store(PostInputDTO $postInputDTO): Post
    {
        $post = $this->postFactory->createPost($postInputDTO);
        return $this->postRepository->store($post, true);
    }

    public function update(Post $post, PostInputDTO $postInputDTO): Post
    {
        $post = $this->postFactory->editPost($post, $postInputDTO);
        return $this->postRepository->update($post);
    }

    public function delete(Post $post): void
    {
        $this->postRepository->delete($post);
    }
}