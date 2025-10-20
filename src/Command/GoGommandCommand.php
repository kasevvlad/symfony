<?php

namespace App\Command;

use App\DTOValidator\PostDTOValidator;
use App\Factory\PostFactory;
use App\ResponseBuilder\PostResponseBuilder;
use App\Service\PostService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'go',
    description: 'Add a short description for your command',
)]
class GoGommandCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private PostService $postService,
        private PostDTOValidator $postDTOValidator,
        private PostResponseBuilder $postResponseBuilder,
        private PostFactory $postFactory,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = [
            'title' => 'test234',
            'description' => 'test',
            'content' => 'test',
            'published_at' => '2025-12-20',
            'status' => 2,
            'category_id' => 1
        ]; 

        $storePostInputDTO = $this->postFactory->makeStorePostDTO($data);

        $this->postDTOValidator->validate($storePostInputDTO);

        $post = $this->postService->store($storePostInputDTO);

        $res = $this->postResponseBuilder->storePost($post);

        dd($res);

        return Command::SUCCESS;
    }
}
