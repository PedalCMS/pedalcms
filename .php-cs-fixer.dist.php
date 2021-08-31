<?php

$config = new PhpCsFixer\Config();
$finder = PhpCsFixer\Finder::create()
    ->exclude('node_modules')
    ->in(__DIR__);

$rules = [
    '@PSR12'                 => true,
    'strict_param'           => true,
    'array_syntax'           => ['syntax' => 'short'],
    'array_indentation'      => true,
    'binary_operator_spaces' => [
        'default'   => 'single_space',
        'operators' => [
            '=>' => 'align_single_space'
        ]
    ],
    'braces' => [
        'position_after_functions_and_oop_constructs' => 'same'
    ]
];

return $config
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setFinder($finder);
