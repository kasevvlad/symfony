<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Service\PostService;
use App\Validator\PostValidator;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'go',
    description: 'Add a short description for your command',
)]
class GoGommandCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private PostService $postService,
        private PostValidator $postValidator
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = [
            'title' => 'test',
            'description' => 'test',
            'content' => 'test',
            'published_at' => '2025-12-20',
            'status' => 2,
            'category_id' => 1
        ]; 

        $post = new Post();
        $category = $this->em->getReference(Category::class, $data['category_id']);

        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setContent($data['content']);
        $post->setPublishedAt(new DateTimeImmutable($data['published_at']));
        $post->setStatus($data['status']);
        $post->setCategory($category);

        $this->postValidator->validate($post);

        $post = $this->postService->store($post);

        return Command::SUCCESS;
    }
}
