<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use BaksDev\Reference\Color\Twig\ColorExtension;
use Symfony\Config\TwigConfig;

return static function(TwigConfig $config) {
	$config->path(__DIR__.'/../view', 'Gender');
};




