<?php

$configPs = new PrestaShop\CodingStandards\CsFixer\Config();

$rules = $configPs->getRules();

$config = new PhpCsFixer\Config();
$rules['global_namespace_import'] = ['import_classes' => false];
//$rules['statement_indentation'] = true;

$config
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->getFinder()
    ->in(__DIR__)
    ->exclude(['vendor', 'node_modules', '202', 'translations', 'config']);

return $config;