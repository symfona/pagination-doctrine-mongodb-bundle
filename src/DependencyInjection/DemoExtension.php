<?php declare(strict_types=1);

namespace Symfona\DemoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

final class DemoExtension extends Extension
{
    /**
     * @param array<string, mixed> $configs
     * @param ContainerBuilder     $container
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
    }
}
