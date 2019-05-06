<?php

namespace PaulEasyVote;

use Shopware\Components\Plugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Shopware-Plugin PaulEasyVote.
 */
class PaulEasyVote extends Plugin
{

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('paul_easy_vote.plugin_dir', $this->getPath());
        parent::build($container);
    }

}
