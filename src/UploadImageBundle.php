<?php

namespace UploadImageBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UploadImageBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
    protected function getContainerExtensionClass(): string
    {
        return 'UploadImageBundle\DependencyInjection\UploadImageExtension'; // ✅ Vérifie bien le chemin
    }
}
