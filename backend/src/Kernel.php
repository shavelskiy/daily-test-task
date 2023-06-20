<?php

declare(strict_types=1);

namespace App;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use Exception;
use Liip\TestFixturesBundle\LiipTestFixturesBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\RouteCollection;

class Kernel extends BaseKernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles(): iterable
    {
        $contents = [
            new FrameworkBundle(),
            new MonologBundle(),
            new DoctrineBundle(),
            new DoctrineMigrationsBundle(),
        ];

        if (class_exists(DoctrineFixturesBundle::class)) {
            $contents[] = new DoctrineFixturesBundle();
        }

        if (class_exists(LiipTestFixturesBundle::class)) {
            $contents[] = new LiipTestFixturesBundle();
        }

        foreach ($contents as $class) {
            yield $class;
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(function (ContainerBuilder $container) use ($loader) {
            $container->loadFromExtension('framework', [
                'router' => [
                    'resource' => 'kernel::loadRoutes',
                    'type' => 'service',
                ],
            ]);

            $container->register('kernel', self::class)
                ->addTag('routing.route_loader')
                ->setAutoconfigured(true)
                ->setSynthetic(true)
                ->setPublic(true)
            ;

            /** @var PhpFileLoader $kernelLoader */
            $kernelLoader = $loader->getResolver()->resolve(__FILE__);

            $instanceOf = [];
            $containerConfigurator = new ContainerConfigurator($container, $kernelLoader, $instanceOf, __FILE__, __FILE__);
            $containerConfigurator->import($this->getProjectDir() . '/config/packages.yaml');
            $containerConfigurator->import($this->getProjectDir() . '/config/doctrine.yaml');
            $containerConfigurator->import($this->getProjectDir() . '/config/services.yaml');
        });
    }

    /**
     * @internal
     */
    public function loadRoutes(LoaderInterface $loader): RouteCollection
    {
        /** @var \Symfony\Component\Routing\Loader\PhpFileLoader $kernelLoader */
        $kernelLoader = $loader->getResolver()->resolve(__FILE__);

        $collection = new RouteCollection();

        (new RoutingConfigurator($collection, $kernelLoader, __FILE__, __FILE__))
            ->import($this->getProjectDir() . '/config/routes.yaml')
        ;

        return $collection;
    }
}
