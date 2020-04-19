<?php

declare(strict_types=1);

namespace Andreo\GuzzleBundle;


use Andreo\GuzzleBundle\DependencyInjection\DecorateClientPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AndreoGuzzleBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new DecorateClientPass());
    }
}