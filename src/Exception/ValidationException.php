<?php

namespace App\Exception;

use RuntimeException;
use Throwable;

class ValidationException extends RuntimeException
{
    public function __construct(private array $errors)
    {
        parent::__construct('Invalidate arguments', 422);
    }

    /**
     * Get the value of errors
     */ 
    public function getErrors(): array
    {
        return $this->errors;
    }
}