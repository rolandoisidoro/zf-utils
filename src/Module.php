<?php
namespace ZFUtils;

/**
 * Module 
 * 
 * @author Rolando Isidoro (https://github.com/rolandoisidoro) 
 */
class Module implements \Zend\ModuleManager\Feature\ConfigProviderInterface
{
    /**
     * getConfig 
     * Retrieve module configuration
     * 
     * @return array The ZFUtils module configuration array
     */
    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }
}

