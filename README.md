<h1 align="center">
    <a href="https://winebuyers.com" target="_blank">
        <img src="https://winebuyers.com/bundles/app/img/winebuyers-logo.svg" style="max-width: 500px" />
    </a>
    <br />
</h1>

# Sylius Sendgrid Plugin
Sendgrid plugin for Sylius.

## This is an alpha package, without releases yet, use it under your responsability

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