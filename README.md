<h1 align="center">
    <a href="https://winebuyers.com" target="_blank">
        <img src="https://winebuyers.com/bundles/app/img/winebuyers-logo.svg" style="max-width: 500px" />
    </a>
    <br />
</h1>

# Sylius Sendgrid Plugin
Sendgrid plugin for Sylius.

## Installation
```bash
$ composer require winebuyers/sylius-sendgrid-plugin
```

Add plugin dependencies to your AppKernel.php file:
```php
public function registerBundles()
{
    return array_merge(parent::registerBundles(), [
        ...
        
        new \Winebuyers\SyliusSendgridPlugin\WinebuyersSyliusSendgridPlugin(),
    ]);
}
```

## Configuration

Configure template with your Sendgrid template id. As Sendgrid templates doesn't support to send them objects, 
you can define your own transformer to transform the data you can send to the Sendgrid template.

```
# app/config/mailer.yml

sylius_mailer:
    sender:
        name: "%mailer_sender_name%"
        address: "%mailer_sender_address%"

winebuyers_sylius_sendgrid:
    emails:
        contact_request:
            subject: Contact from %%user%%
            template: '9de8bfd2-bd81-4d08-a7ff-6cfb50c9711d'
            enabled: true
            transformer: Winebuyers\SyliusSendgridPlugin\Transformers\UserTransformer
        user_registration:
            subject: Welcome %%user%%
            template: '9de8bfd2-bd81-4d08-a7ff-6cfb50c9711d'
            enabled: true
            transformer: Winebuyers\SyliusSendgridPlugin\Transformers\UserRegistrationTransformer
        verification_token:
            subject: '%%name%% welcome to Winebuyers'
            template: 'a2db7036-eb4c-4f16-bf15-2a370562a6ec'
            enabled: true
            transformer: Winebuyers\SyliusSendgridPlugin\Transformers\VerificationTokenTransformer
        password_reset:
            subject: Reset your password
            template: '0c8bce03-5f15-4741-af1c-2d698cc22055'
            enabled: true
            transformer: Winebuyers\SyliusSendgridPlugin\Transformers\ResetPasswordTransformer
        reset_password_token:
            subject: Password reseted
            template: '15571ac6-4406-4e68-97e3-5c48f3caf654'
            enabled: true
            transformer: Winebuyers\SyliusSendgridPlugin\Transformers\ResetPasswordTransformer
        order_confirmation:
            subject: Order confirmed
            template: 'b656b788-4ffa-42e4-ae7e-b715373c378c'
            enabled: true
            transformer: Winebuyers\SyliusSendgridPlugin\Transformers\OrderTransformer
        shipment_confirmation:
            subject: Order shipped
            template: 'b656b788-4ffa-42e4-ae7e-b715373c378c'
            enabled: true
            transformer: Winebuyers\SyliusSendgridPlugin\Transformers\OrderTransformer
```

