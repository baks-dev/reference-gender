<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use BaksDev\Reference\Gender\Type\Gender;
use BaksDev\Reference\Gender\Type\GenderType;
use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine)
{
    $doctrine->dbal()->type(Gender::TYPE)->class(GenderType::class);
};