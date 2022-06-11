<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->exclude('bootstrap/cache')
    ->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php')
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    //'strict_param' => true,
    'array_syntax' => ['syntax' => 'short'],
    'align_multiline_comment' => ['comment_type' => 'phpdocs_only'],
])
    ->setFinder($finder);
