<?php

namespace PaulEasyVote;

use League\Flysystem\Exception;
use Shopware\Components\Plugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;


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

    /**
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $this->createCheckoutAttr();
        $this->createMailTemplate();
    }

    /**
     * @param UninstallContext $context
     */
    public function uninstall(UninstallContext $context)
    {
        $mail = Shopware()->Models()->getRepository('\Shopware\Models\Mail\Mail')->findOneBy(array('name' => "PaulVoteRemember"));

        if (!is_null($mail)) {
            Shopware()->Models()->remove($mail);
        }
    }

    private function createCheckoutAttr()
    {
        /** @var CrudService $crudService */
        $crudService = $this->container->get('shopware_attribute.crud_service');
        $crudService->update('s_order_attributes', 'paul_vote_permission',
            'text', [
                'label' => 'Bewertungsanfrage erlaubt?',
                'supportText' => 'Zustimmung zur bewertung gegeben',
                'displayInBackend' => true
            ]);
        // Rebuild attribute models
        /** @var ModelManager $modelManager */
        $modelManager = $this->container->get('models');
    }

    private function createMailTemplate(){

        // read from our files
        $content = file_get_contents( __DIR__ . '/../PaulEasyVote/Install/email_template_content.txt');
        $html    = file_get_contents( __DIR__ . '/../PaulEasyVote/Install/email_template_html.txt');
        $name = 'PaulVoteRemember';

        // create a new object
        $mail = new \Shopware\Models\Mail\Mail();

        // set all parameters
        $mail->setName( $name );
        $mail->setFromMail( "{config name=mail}" );
        $mail->setFromName( "{config name=shopName}" );
        $mail->setSubject( "Produkte bewerten - {config name=shopName}" );
        $mail->setContent( $content );
        $mail->setContentHtml( $html );
        $mail->setIsHtml( true );
        $mail->setMailtype( 1 );
        $mail->setContext( null );

        // save it
        Shopware()->Models()->persist( $mail );
        Shopware()->Models()->flush();

    }

}
