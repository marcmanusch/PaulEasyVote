<?php
/**
 *
 */
namespace PaulEasyVote\Subscriber;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Enlight\Event\SubscriberInterface;

class Checkout implements SubscriberInterface
{
    /** @var  ContainerInterface */
    private $container;
    /**
     * Frontend contructor.
     * @param ContainerInterface $container
     **/
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * Get the subscribed events.
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Modules_Order_SaveOrder_FilterParams' => 'saveOrderFilterParams',
        ];
    }
    /**
     *
     * @param \Enlight_Event_EventArgs $args
     * @Enlight\Event Shopware_Modules_Order_SaveOrder_FilterParams
     */
    public function saveOrderFilterParams(\Enlight_Event_EventArgs $args)
    {
        $session = $this->container->get('Session');
        $order = $args->getSubject();

        //Hole Wert aus Session und speichere diesen als Order Attribut
        $order->orderAttributes['paul_vote_permission'] = $session->get('paulVoting');

        $session->paulVoting = '';

    }
}