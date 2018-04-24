<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\Transformers;

use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OrderTransformer implements SendgridTransformersInterface {
	
	private $router;

	public function __construct(Router $router) {
		$this->router = $router;
	}

	public function transform(array $data): array
	{

		
 		return $data;
	}
}
