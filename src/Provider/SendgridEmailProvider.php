<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\Provider;

use Sylius\Component\Mailer\Provider\EmailProviderInterface;
use Sylius\Component\Mailer\Factory\EmailFactoryInterface;
use Sylius\Component\Mailer\Model\EmailInterface;
use Webmozart\Assert\Assert;

final class SendgridEmailProvider implements EmailProviderInterface
{
    /**
     * @var EmailFactoryInterface
     */
    private $emailFactory;

    /**
     * @var array
     */
    private $configuration;

    /**
     * @param EmailFactoryInterface $emailFactory
     * @param array $configuration
     */
    public function __construct(
        EmailFactoryInterface $emailFactory,
        array $configuration
    ) {
        $this->emailFactory = $emailFactory;
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(string $code): EmailInterface
    {
        return $this->getEmailFromConfiguration($code);
    }

    /**
     * @param string $code
     *
     * @return EmailInterface
     */
    private function getEmailFromConfiguration(string $code): EmailInterface
    {
        Assert::keyExists($this->configuration, $code, sprintf('Email with code "%s" does not exist!', $code));

        /** @var EmailInterface $email */
        $email = $this->emailFactory->createNew();
        $configuration = $this->configuration[$code];

        $email->setCode($code);
        $email->setSubject($configuration['subject']);
        $email->setTemplateId($configuration['template']);

        if (isset($configuration['enabled']) && false === $configuration['enabled']) {
            $email->setEnabled(false);
        }
        if (isset($configuration['sender']['name'])) {
            $email->setSenderName($configuration['sender']['name']);
        }
        if (isset($configuration['sender']['address'])) {
            $email->setSenderAddress($configuration['sender']['address']);
        }

        return $email;
    }
}
