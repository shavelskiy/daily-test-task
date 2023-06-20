
<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

return (new PhpCsFixer\Config())
    ->setCacheFile(__DIR__ . '/var/.php-cs-fixer.cache')
    ->setRules([
        '@Symfony' => true,
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        '@DoctrineAnnotation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'yoda_style' => false,
        'concat_space' => ['spacing' => 'one'],
        'cast_spaces' => ['space' => 'none'],
        'blank_line_before_statement' => false,
        'class_attributes_separation' => false,
        'no_superfluous_phpdoc_tags' => false,
        'single_line_comment_style' => false,
        'declare_strict_types' => true,
        'global_namespace_import' => true,
    ])
    ->setFinder($finder);
