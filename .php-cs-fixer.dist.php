<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'                      => true,
        'array_syntax'                => ['syntax' => 'short'],
        'single_quote'                => true,
        'no_unused_imports'           => true,
        'trailing_comma_in_multiline' => true,
        'binary_operator_spaces'      => ['default' => 'align_single_space_minimal'],
    ])
    ->setFinder($finder);