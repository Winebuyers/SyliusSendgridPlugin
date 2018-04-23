<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\Adapter;

interface SendgridEmailDataAdapterInterface
{
    public function transform(array $data): array;
}
