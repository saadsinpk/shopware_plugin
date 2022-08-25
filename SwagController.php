<?php

namespace SwagController;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;

class SwagController extends Plugin
{
    /**
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $KF_Filter_length = $service->get('s_filter_options_attributes', 'sidtechno_filter_length');

        if(!$KF_Filter_length){
            $service->update('s_filter_options_attributes', 'sidtechno_filter_length', 'boolean', [
                'label' => 'Length Filed',
                'displayInBackend' => true
            ]);

        }

        $KF_Filter_height = $service->get('s_filter_options_attributes', 'sidtechno_filter_height');

        if(!$KF_Filter_height){
            $service->update('s_filter_options_attributes', 'sidtechno_filter_height', 'boolean', [
                'label' => 'Height Filed',
                'displayInBackend' => true
            ]);

        }

        $KF_Filter_width = $service->get('s_filter_options_attributes', 'sidtechno_filter_width');

        if(!$KF_Filter_width){
            $service->update('s_filter_options_attributes', 'sidtechno_filter_width', 'boolean', [
                'label' => 'Width Filed',
                'displayInBackend' => true
            ]);

        }

    }

    /**
     * @param UpdateContext $context
     */
    public function update(UpdateContext $context)
    {
        $context->scheduleClearCache(UpdateContext::CACHE_LIST_ALL);
    }

    /**
     * @param ActivateContext $context
     */
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    /**
     * @param DeactivateContext $context
     */
    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }

    /**
     * @param UninstallContext $context
     */
    public function uninstall(UninstallContext $context)
    {

        if (!$context->keepUserData()) {
            $service = $this->container->get('shopware_attribute.crud_service');
            $service->delete('s_filter_options_attributes', 'sidtechno_filter_length');
            $service->delete('s_filter_options_attributes', 'sidtechno_filter_height');
            $service->delete('s_filter_options_attributes', 'sidtechno_filter_width');
        }
        
        $context->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);
    }
}