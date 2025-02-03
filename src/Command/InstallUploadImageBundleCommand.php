<?php

namespace UploadImageBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class InstallUploadImageBundleCommand extends Command
{
    private $filesystem;
    private $params;

    public function __construct(Filesystem $filesystem, ParameterBagInterface $params)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
        $this->params = $params;
    }

    protected static $defaultName = 'upload-image-bundle:install';

    protected function configure()
    {
        $this->setDescription('Installe et configure UploadImageBundle avec des emplacements personnalisés pour les fichiers.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // Demande à l'utilisateur de spécifier les emplacements
        $documentsDir = $io->ask('Veuillez entrer le dossier pour les documents (PDF, DOC, CSV, etc.)', $this->params->get('upload_image_bundle.documents_dir'));
        $videosDir = $io->ask('Veuillez entrer le dossier pour les vidéos (MP4, AVI, etc.)', $this->params->get('upload_image_bundle.videos_dir'));
        $imagesDir = $io->ask('Veuillez entrer le dossier pour les images (JPG, PNG, GIF, etc.)', $this->params->get('upload_image_bundle.images_dir'));

        // Crée les dossiers si ils n'existent pas
        $filesystem = new Filesystem();
        $filesystem->mkdir($documentsDir);
        $filesystem->mkdir($videosDir);
        $filesystem->mkdir($imagesDir);

        // Met à jour le fichier de configuration YAML
        $configFilePath = __DIR__ . '/../../config/packages/upload_image_bundle.yaml';

        $newConfig = sprintf(
            "upload_image_bundle:\n    documents_dir: '%s'\n    videos_dir: '%s'\n    images_dir: '%s'\n",
            $documentsDir, $videosDir, $imagesDir
        );

        file_put_contents($configFilePath, $newConfig);

        $io->success("Les emplacements ont été configurés avec succès !");

        return Command::SUCCESS;
    }
}
