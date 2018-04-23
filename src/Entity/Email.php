<?php

declare (strict_types = 1);

namespace Winebuyers\SyliusSendgridPlugin\Entity;

use Sylius\Component\Mailer\Model\EmailInterface;

final class Email implements EmailInterface
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var bool
     */
    private $enabled = true;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $template_id;

    /**
     * @var string
     */
    private $senderName;

    /**
     * @var string
     */
    private $senderAddress;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function disable(): void
    {
        $this->enabled = false;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderName(string $senderName): void
    {
        $this->senderName = $senderName;
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderAddress(): ?string
    {
        return $this->senderAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderAddress(string $senderAddress): void
    {
        $this->senderAddress = $senderAddress;
    }

    /**
     * @return string
     */
    public function getTemplateId(): ?string
    {
        return $this->template_id;
    }

    /**
     * @param string $template_id
     *
     * @return self
     */
    public function setTemplateId(string $template_id)
    {
        $this->template_id = $template_id;

        return $this;
    }
}
