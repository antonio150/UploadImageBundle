<?php

namespace UploadImageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('upload_image_bundle');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('documents_dir')
                    ->defaultValue('%kernel.project_dir%/public/uploads/documents')
                    ->info('Dossier où seront stockés les documents (PDF, DOC, XLS, CSV, etc.)')
                ->end()
                ->scalarNode('videos_dir')
                    ->defaultValue('%kernel.project_dir%/public/uploads/videos')
                    ->info('Dossier où seront stockées les vidéos (MP4, AVI, MOV, etc.)')
                ->end()
                ->scalarNode('images_dir')
                    ->defaultValue('%kernel.project_dir%/public/uploads/images')
                    ->info('Dossier où seront stockées les images (JPG, PNG, GIF, etc.)')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
