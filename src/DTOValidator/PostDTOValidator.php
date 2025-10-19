<?php

namespace App\DTOValidator;

use App\DTO\Input\StorePostInputDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostDTOValidator
{
    public function __construct(
        private ValidatorInterface $validator
    )
    {
        
    }
    public function validate(StorePostInputDTO $post): void
    {
        $errors = $this->validator->validate($post);

        if(count($errors) > 0){
            $messages = [];
            foreach($errors as $error){
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }
            throw new \InvalidArgumentException(json_encode($messages));
        }
    }
}