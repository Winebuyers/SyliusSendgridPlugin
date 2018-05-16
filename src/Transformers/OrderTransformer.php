<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\Transformers;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OrderTransformer implements SendgridTransformersInterface {
	
	private $container;
	private $router;

	public function __construct(Container $container, Router $router) {
		$this->container = $container;
		$this->router = $router;
	}

	public function transform(array $data): array
	{
        $order = $data['order'];
		
 		return $data;
	}
}
