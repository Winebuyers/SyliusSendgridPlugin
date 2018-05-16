<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Routing\Router;

use Sylius\Component\Mailer\Event\EmailSendEvent;
use Sylius\Component\Mailer\Model\EmailInterface;
use Sylius\Component\Mailer\Renderer\RenderedEmail;
use Sylius\Component\Mailer\Sender\Adapter\AbstractAdapter;
use Sylius\Component\Mailer\SyliusMailerEvents;

use Winebuyers\SyliusSendgridPlugin\Transformers\SendgridTransformersInterface;
use Webmozart\Assert\Assert;
use Smtpapi\Header;

class SendgridMailerAdapter extends AbstractAdapter
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    protected $router;
    protected $container;

    protected $configuration;
    protected $expressionLanguage;

    protected $data = [];

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(
        \Swift_Mailer $mailer,
        array $configuration,
        Router $router,
        Container $container
    )
    {
        $this->mailer = $mailer;
        $this->configuration = $configuration;
        $this->router = $router;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function send(
        array $recipients,
        string $senderAddress,
        string $senderName,
        RenderedEmail $renderedEmail,
        EmailInterface $email,
        array $data,
        array $attachments = [],
        array $replyTo = []
    ): void {

        $this->data = $data;
        $config =  $this->configuration[$email->getCode()];
        
        if(isset($config['transformer'])) {
            $this->transormData($config['transformer']);
        }

        $message = (new \Swift_Message())
            ->setSubject($this->replaceSubjectWithData($email))
            ->setFrom([$senderAddress => $senderName])
            ->setTo($recipients)
            ->setReplyTo($replyTo)
            ->setContentType('text/html');


        $header = new Header;
        $filter = [
            'templates' => [
                'settings' => [
                    'enable' => 1,
                    'template_id' => $email->getTemplateId(),
                ]
            ]
        ];
        $header->setFilters($filter);        

        foreach ($this->data as $key => $value) {
            $header->addSubstitution($this->getSubstitutionKey($key), [$value]);
        }

        foreach ($recipients as $recipient) {
            $header->addTo($recipient);
        }

        $message_headers  = $message->getHeaders();
        $message_headers->addTextHeader(Header::NAME, $header->jsonString());
        $message_headers->addParameterizedHeader(Header::NAME, $header->jsonString());
        
        $emailSendEvent = new EmailSendEvent($message, $email, $data, $recipients, $replyTo);

        $this->dispatcher->dispatch(SyliusMailerEvents::EMAIL_PRE_SEND, $emailSendEvent);
        $this->mailer->send($message);
        $this->dispatcher->dispatch(SyliusMailerEvents::EMAIL_POST_SEND, $emailSendEvent);
    }

    private function transormData(string $transformerClass): void
    {
        $instance = $this->container->get($transformerClass);

        Assert::implementsInterface($instance, SendgridTransformersInterface::class);

        $this->data = $instance->transform($this->data);
    }

    private function replaceSubjectWithData($email)
    {
        $subject = $email->getSubject();

        foreach ($this->data as $key => $value) {
            if(is_string($value))
                $subject = str_replace($this->getSubstitutionKey($key), $value, $subject);
        }

        return $subject;
    }

    private function getSubstitutionKey($str)
    {
        return '%'.$str.'%';
    }
}
