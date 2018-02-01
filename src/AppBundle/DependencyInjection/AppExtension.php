<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * @package    AppBundle\DependencyInjection
 * @author     Krzysztof Trzos
 */
class AppExtension extends Extension implements PrependExtensionInterface
{
    /** @inheritdoc */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');
    }

    /** @inheritdoc */
    public function prepend(ContainerBuilder $container)
    {

    }
}