<?php

use Shopware\Components\CSRFWhitelistAware;

/**
 * Class Shopware_Controllers_Frontend_PaulAjaxVoteCheck
 */
class Shopware_Controllers_Frontend_PaulAjaxVoteCheck extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    public function getWhitelistedCSRFActions()
    {
        return [
            'index',
            'saveVotingCheckbox'
        ];
    }

    public function indexAction(){
       #not implemented
    }

    public function saveVotingCheckboxAction(){

        $this->container->get('front')->Plugins()->ViewRenderer()->setNoRender();

        $formData = $this->Request()->getPost();
        $paulVoting = $formData['votingCheck'];

        $session = $this->container->get('session');

        $view = $this->View();
        $view->assign('paulVoting', $paulVoting);

        $session->paulVoting = $paulVoting;
    }
}