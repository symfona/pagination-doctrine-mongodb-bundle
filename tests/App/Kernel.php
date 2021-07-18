<?php declare(strict_types=1);

namespace Symfona\Pagination\Doctrine\MongoDB\AdapterBundle\Tests\App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends \Symfony\Component\HttpKernel\Kernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        yield new \Symfony\Bundle\FrameworkBundle\FrameworkBundle();
        yield new \Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle();
        yield new \Symfona\Pagination\Doctrine\MongoDB\AdapterBundle\AdapterBundle();

        if ('exclude_pagination' !== $this->getEnvironment()) {
            yield new \Symfona\PaginationBundle\PaginationBundle();
        }
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('config/config.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
    }
}
