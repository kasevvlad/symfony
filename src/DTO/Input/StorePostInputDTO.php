<?php

namespace App\DTO\Input;

use App\Entity\Category;
use App\Validator\Constraint\EntityExists;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class StorePostInputDTO
{
        #[Assert\NotBlank(allowNull: null, normalizer: 'trim')]
        #[Assert\Length(min: 1, max: 255)] 
        public ?string $title = null;

        #[Assert\NotBlank(allowNull: true, normalizer: 'trim')]
        public ?string $description = null;

        #[Assert\NotBlank(allowNull: null, normalizer: 'trim')]
        public ?string $content = null;

        #[Assert\Type(DateTimeImmutable::class)]
        public ?\DateTimeImmutable $publishedAt = null;

        #[Assert\NotNull]
        #[Assert\Type(type: 'integer')]
        public ?int $status = 1;

        #[Assert\NotNull]
        #[EntityExists(entity: Category::class)]
        public ?int $categoryId = null;
}