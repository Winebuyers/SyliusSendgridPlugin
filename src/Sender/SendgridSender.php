<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\Sender;

use Sylius\Component\Mailer\Provider\DefaultSettingsProviderInterface;
use Sylius\Component\Mailer\Provider\EmailProviderInterface;
use Sylius\Component\Mailer\Renderer\Adapter\AdapterInterface as RendererAdapterInterface;
use Sylius\Component\Mailer\Sender\Adapter\AdapterInterface as SenderAdapterInterface;
use Sylius\Component\Mailer\Renderer\RenderedEmail;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class SendgridSender implements SenderInterface
{
    /**
     * @var RendererAdapterInterface
     */
    private $rendererAdapter;

    /**
     * @var SenderAdapterInterface
     */
    private $senderAdapter;

    /**
     * @var EmailProviderInterface
     */
    private $provider;

    /**
     * @var DefaultSettingsProviderInterface
     */
    private $defaultSettingsProvider;

    /**
     * @param RendererAdapterInterface $rendererAdapter
     * @param SenderAdapterInterface $senderAdapter
     * @param EmailProviderInterface $provider
     * @param DefaultSettingsProviderInterface $defaultSettingsProvider
     */
    public function __construct(
        RendererAdapterInterface $rendererAdapter,
        SenderAdapterInterface $senderAdapter,
        EmailProviderInterface $provider,
        DefaultSettingsProviderInterface $defaultSettingsProvider
    ) {
        $this->senderAdapter = $senderAdapter;
        $this->rendererAdapter = $rendererAdapter;
        $this->provider = $provider;
        $this->defaultSettingsProvider = $defaultSettingsProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function send(string $code, array $recipients, array $data = [], array $attachments = [], array $replyTo = []): void
    {
        $email = $this->provider->getEmail($code);

        if (!$email->isEnabled()) {
            return;
        }

        $senderAddress = $email->getSenderAddress() ?: $this->defaultSettingsProvider->getSenderAddress();
        $senderName = $email->getSenderName() ?: $this->defaultSettingsProvider->getSenderName();

        $renderedEmail = new RenderedEmail($email->getSubject(), $email->getContent() ?: ''); //$this->rendererAdapter->render($email, $data);

        $this->senderAdapter->send(
            $recipients,
            $senderAddress,
            $senderName,
            $renderedEmail,
            $email,
            $data,
            $attachments,
            $replyTo
        );
    }
}
