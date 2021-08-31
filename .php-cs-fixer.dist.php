<?php


$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->exclude(['src/acf','node_modules'])
    ->ignoreDotFiles(true);


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

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setFinder($finder);
