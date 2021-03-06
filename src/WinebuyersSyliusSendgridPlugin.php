<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;

use Winebuyers\SyliusSendgridPlugin\DependencyInjection\WinebuyersSyliusSendgridExtension;

final class WinebuyersSyliusSendgridPlugin extends Bundle
{
    use SyliusPluginTrait;
}