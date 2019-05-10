<?php

namespace PaulEasyVote\Subscriber;

use Enlight\Event\SubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PaulEasyVoteCron
 * @package PaulVoteExportGoogle\Subscriber
 */
class PaulEasyVoteCron implements SubscriberInterface
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
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_PaulEasyVoteCron' => 'SendVotingMail'
        ];
    }

    /**
     * @param \Shopware_Components_Cron_CronJob $job
     * @return string
     */
    public function SendVotingMail(\Shopware_Components_Cron_CronJob $job)
    {
        // Get plugin configuration
        $config = $this->container->get('shopware.plugin.config_reader')->getByPluginName('PaulEasyVote');
        $active = $config['active'];
        $paulVoteDate = $config['paulVoteDate'];

        // counts the sended mails.
        $counter = 0;
        $mails = '';

        if($active) {
            $orders = $this->getOrdersForVotingMail($paulVoteDate);

            if($orders) {
                foreach ($orders as $order) {

                    $mail = Shopware()->TemplateMail()->createMail('PaulVoteRemember', array(
                        'name'              => $order['firstname'] . ' ' . $order['lastname'],
                        'ordernumber'       => $order['ordernumber'],
                        'mail'              => $order['email']
                    ));

                    $mail->addTo($order['email'], $order['name']);
                    $mail->send();
                    $counter++;
                    $mails = $mails . ', ' . $order['email'];
                }
            }
        }

        return 'Es wurden ' . $counter . ' Mails versendet. ' . $mails;
    }


    public function getOrdersForVotingMail($paulVoteDate) {
        $orders = [];

        $today = Date('Y-m-d');
        $voteDate = strtotime($today." -".$paulVoteDate." day");
        $voteDate = Date('Y-m-d', $voteDate);



        $from = $voteDate." 00:00:00";
        $to   = $voteDate." 23:59:59";

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->container->get('dbal_connection');
        $builder = $connection->createQueryBuilder();
        $builder->select('sob.firstname, sob.lastname, su.email, so.ordernumber')
            ->from('s_order', 'so')
            ->innerJoin('so',
                's_order_billingaddress',
                'sob',
                'so.id = sob.orderID')
            ->innerJoin('so',
                's_order_attributes',
                'soa',
                'so.id = soa.orderID')
            ->innerJoin('so',
                's_user',
                'su',
                'so.userID = su.id')
            ->where('soa.paul_vote_permission = true')
            ->andWhere('so.ordertime BETWEEN :from AND :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to);

        $stmt = $builder->execute();
        $orders = $stmt->fetchAll();

        return $orders;
    }


}