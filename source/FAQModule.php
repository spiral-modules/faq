<?php

namespace Spiral;

use Spiral\Core\DirectoriesInterface;
use Spiral\Modules\ModuleInterface;
use Spiral\Modules\PublisherInterface;
use Spiral\Modules\RegistratorInterface;

class FAQModule implements ModuleInterface
{
    /**
     * @inheritDoc
     */
    public function register(RegistratorInterface $registrator)
    {
        //Register tokenizer directory
        $registrator->configure('tokenizer', 'directories', 'spiral/faq', [
            "directory('libraries') . 'spiral/faq/source/FAQ/Database/',",
        ]);

        //Register database settings
        $registrator->configure('databases', 'aliases', 'spiral/faq', [
            "'faq' => 'default',",
        ]);

        //Register view namespace
        $registrator->configure('views', 'namespaces', 'spiral/faq', [
            "'faq' => [",
            "    directory('libraries') . 'spiral/faq/source/views/',",
            "    /*{{namespaces.faq}}*/",
            "],",
        ]);

        //Register controller in vault config
        $registrator->configure('modules/vault', 'controllers', 'spiral/faq', [
            "'faq' => \\Spiral\\FAQ\\Controllers\\FAQController::class,",
        ]);
    }

    /**
     * @inheritDoc
     */
    public function publish(PublisherInterface $publisher, DirectoriesInterface $directories)
    {
    }
}