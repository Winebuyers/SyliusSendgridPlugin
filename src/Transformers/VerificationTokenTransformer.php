<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\Transformers;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class VerificationTokenTransformer extends UserTransformer implements SendgridTransformersInterface {
	
	private $container;
	private $router;

	public function __construct(Container $container, Router $router) {
		$this->container = $container;
		$this->router = $router;
	}

	public function transform(array $data): array
	{
		$data = parent::transform($data);
		$user = $data['user'];

		if($user != null) {
			$data['name'] = $user->getCustomer()->getFullName();
			$data['verification_url'] = $this->router->generate('sylius_shop_user_verification', [
				            		'token' => $user->getEmailVerificationToken()
				        		], UrlGeneratorInterface::ABSOLUTE_URL);
		}

 		return $data;
	}
}
