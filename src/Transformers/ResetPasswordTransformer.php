<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\Transformers;

use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ResetPasswordTransformer extends UserTransformer implements SendgridTransformersInterface {
	
	private $router;

	public function __construct(Router $router) {
		$this->router = $router;
	}

	public function transform(array $data): array
	{
		$data = parent::transform($data);
		$user = $data['user'];

		if($user != null) {
			$data['name'] = $user->getCustomer()->getFullName();
			$data['reset_password_url'] = $this->router->generate('sylius_shop_password_reset', [
                                                'token' => $user->getPasswordResetToken()
                                            ], UrlGeneratorInterface::ABSOLUTE_URL);
		}

        unset($data['user']);
        unset($data['channel']);

 		return $data;
	}
}
