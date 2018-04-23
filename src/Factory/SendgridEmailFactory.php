<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\Factory;

use Winebuyers\SyliusSendgridPlugin\Entity\Email;
use Sylius\Component\Mailer\Model\EmailInterface;
use Sylius\Component\Mailer\Factory\EmailFactoryInterface;

class SendgridEmailFactory implements EmailFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(): EmailInterface
    {
        return new Email();
    }
}
