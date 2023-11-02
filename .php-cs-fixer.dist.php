<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__.'/app',   // Replace with your actual source directory
        __DIR__.'/tests', // Replace with your actual tests directory
    ])
    ->name('*.php');

$config = new PhpCsFixer\Config();
return $config
    ->setFinder($finder)
    ->setRules([
        // Define your rules here
    ]);
