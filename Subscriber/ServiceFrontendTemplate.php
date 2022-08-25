<?php

namespace BrandCrockServiceButton\Subscriber;

use Enlight\Event\SubscriberInterface;

class ServiceFrontendTemplate implements SubscriberInterface
{

    // private $pluginDirectory;

    // private $pluginName;

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Index' => 'onFrontendPostDispatchSecure'
        ];
    }
    public function __construct($pluginName, $pluginDirectory)
    {
        // $this->pluginDirectory = $pluginDirectory;
        // $this->pluginName = $pluginName;
    }

    public function onFrontendPostDispatchSecure(\Enlight_Event_EventArgs $args)
    {
        echo 'buddy test';
        exit();
        // $shop = false;
        // if (Shopware()->container()->initialized('shop')) {
        //     $shop = Shopware()->container()->get('shop');
        // }
        // $configServiceData = Shopware()->Container()->get('shopware.plugin.cached_config_reader')->getByPluginName($this->pluginName, $shop);
        // $bcenable = $configServiceData['bcenable'];
        // if (empty($bcenable)) {
        //     return;
        // }
        // $view = $args->getSubject()->View();
        // $fetchServiceData = [];
        // $view->addTemplateDir($this->pluginDirectory . '/Resources/Views/');
        // $serviceButtonColor = $configServiceData['buttonColor'];
        // $TemplateVariables = $view->getAssign();
        // $fetchServiceData['bcgh_service_button_title'] = $TemplateVariables['sArticle']['bcgh_service_button_title'];
        // $fetchServiceData['bcgh_service_button_link'] = $TemplateVariables['sArticle']['bcgh_service_button_link'];
        // $fetchServiceData['bcgh_service_button_target'] = $TemplateVariables['sArticle']['bcgh_service_button_target'];
        // $view->assign('ServicesData', $fetchServiceData);
        // $view->assign('serviceButtonColor', $serviceButtonColor);
    }
}
