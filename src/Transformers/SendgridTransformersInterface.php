<?php

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\Transformers;

interface SendgridTransformersInterface
{
    public function transform(array $data): array;
}
