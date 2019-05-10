<?php

use Shopware\Components\CSRFWhitelistAware;

/**
 * Frontend controller
 */
class Shopware_Controllers_Frontend_PaulEasyVote extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    public function getWhitelistedCSRFActions()
    {
        return [
            'index',
            'validation'
        ];
    }

    public function indexAction()
    {
        $view = $this->View();
        $show = false;
        $view->assign('voteComplete', false);

        # Get the GET-Param from URL
        $order = $this->Request()->getParam('bestellnummer');


        if(!is_numeric($order)){

            $view->assign('errorOrdernumberNotInt', true);
            $show = false;
            $order = 0;
        }

        if($this->checkIfOrdernumberExist($order)) {
            $show = true;
        } else {
            # Ordernumber does not exists
            $view->assign('errorOrdernumberNotExists', true);
        }



        if($show) {
            $orderdata = $this->getOrderData($order);

            $mpns = array();
            foreach ($orderdata as $key => $item) {
                try {
                    $articleModule = Shopware()->Modules()->Articles();
                    $articleID = $articleModule->sGetArticleIdByOrderNumber($item['articleordernumber']);
                    $article = $articleModule->sGetArticleById($articleID);
                    $mpns[$key] = $article;
                } catch (\Exception$e) {
                }
            }

            $view->assign('order', $mpns);
            $view->assign('orderdata', $orderdata);
        }

        $view->assign('show', $show);
        $view->assign('bestellnummer', $order);

    }

    public function validationAction() {

        $view = $this->View();

        $anzahl = $this->Request()->getParam('anzahl');
        $shopID = $this->Request()->getParam('shopID');
        $bestellnummer = $this->Request()->getParam('bestellnummer');


        $i = 1;
        $view->assign('voteComplete', false);

        $votes = array();

        while($i <= $anzahl) {
            $votes[$i]['bewertungstext'] = $this->Request()->getParam('bewertungstext'.$i);
            $votes[$i]['bewertung'] = $this->Request()->getParam('bewertung'.$i);
            $votes[$i]['articleID'] = $this->Request()->getParam('articleID'.$i);
            $name = $this->getName($bestellnummer);
            $votes[$i]['name'] = $name[0]['firstname'] . ' ' . $name[0]['lastname'];
            $i++;
        }



        foreach ($votes as $vote) {
            if ($vote['bewertungstext']) {
                $this->submitVotes($vote, $shopID);
            }
        }

        /*echo '<pre>';
        var_dump($vote);
        echo '</pre>';
        die;*/

        $view->assign('voteComplete', true);
    }

    public function getName($bestellnummer) {

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->container->get('dbal_connection');
        $builder = $connection->createQueryBuilder();
        $builder->select('firstname, lastname')
            ->from('s_order', 'so')
            ->innerJoin('so',
                's_order_billingaddress',
                'sob',
                'so.id = sob.orderID')
            ->where('ordernumber = ?')
            ->setParameter(0, $bestellnummer);
        $stmt = $builder->execute();
        return $stmt->fetchAll();


    }

    public function submitVotes($vote, $shopID) {

            /** @var \Doctrine\DBAL\Connection $connection */
            $connection = $this->container->get('dbal_connection');
            $builder = $connection->createQueryBuilder();
            $builder->insert('s_articles_vote')
                ->values(
                    array(
                        'articleID' => '?',
                        'comment'   => '?',
                        'points'    => '?',
                        'headline'  => '?',
                        'shop_id'   => '?',
                        'datum'   => '?',
                        'name'   => '?'
                    )
                )
                ->setParameter(0, $vote['articleID'])
                ->setParameter(1, $vote['bewertungstext'])
                ->setParameter(2, $vote['bewertung']/2)
                ->setParameter(3, substr($vote['bewertungstext'],0,25).'...')
                ->setParameter(4, $shopID)
                ->setParameter(5, date("Y-m-d H:i:s"))
                ->setParameter(6, $vote['name']);

            $builder->execute();
    }

    /**
     * @param $order
     * @return array
     */
    private function checkIfOrdernumberExist($order) {

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->container->get('dbal_connection');
        $builder = $connection->createQueryBuilder();
        $builder->select('so.ordernumber')
            ->from('s_order', 'so')
            ->where('so.ordernumber = ?')
            ->setParameter(0, $order);
        $stmt = $builder->execute();
        return $stmt->fetchAll();
    }


    /**
     * @param $order
     * @return array
     */
    private function getOrderData($order) {

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->container->get('dbal_connection');
        $builder = $connection->createQueryBuilder();
        $builder->select('sod.ordernumber, articleID, articleordernumber, ordertime')
            ->from('s_order_details', 'sod')
            ->innerJoin('sod',
                's_order',
                'so',
                'so.id = sod.orderID')
            ->where('sod.ordernumber = ?')
            ->setParameter(0, $order);
        $stmt = $builder->execute();
        return $stmt->fetchAll();
    }

}
