<?php

namespace UploadImageBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UploadImageBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return 'UploadImageBundle\DependencyInjection\UploadImageExtension'; // ✅ Vérifie bien le chemin
    }

}
