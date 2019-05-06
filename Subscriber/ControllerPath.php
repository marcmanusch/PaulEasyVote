<?php

namespace PaulEasyVote\Subscriber;

use Enlight\Event\SubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerPath implements SubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
                        'Enlight_Controller_Dispatcher_ControllerPath_Frontend_PaulEasyVote' => 'onGetControllerPathFrontend',        );
    }



    /**
     * Register the frontend controller
     *
     * @param   \Enlight_Event_EventArgs $args
     * @return  string
     * @Enlight\Event Enlight_Controller_Dispatcher_ControllerPath_Frontend_PaulEasyVote     */
    public function onGetControllerPathFrontend(\Enlight_Event_EventArgs $args)
    {
        $this->container->get('template')->addTemplateDir(__DIR__ . '/../Resources/views/');
        return __DIR__ . '/../Controllers/Frontend/PaulEasyVote.php';
    }
}
