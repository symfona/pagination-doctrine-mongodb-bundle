<?php declare(strict_types=1);

namespace Symfona\Pagination\Doctrine\MongoDB\AdapterBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class PaginationMongoDBAdapterBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new DependencyInjection\PaginationMongoDBAdapterPass());
    }
}
