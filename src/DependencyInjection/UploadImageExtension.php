<?php

namespace UploadImageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class UploadImageBundleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Définir les paramètres de stockage
        $container->setParameter('upload_image_bundle.documents_dir', $config['documents_dir']);
        $container->setParameter('upload_image_bundle.videos_dir', $config['videos_dir']);
        $container->setParameter('upload_image_bundle.images_dir', $config['images_dir']);

        // Charger les services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}
