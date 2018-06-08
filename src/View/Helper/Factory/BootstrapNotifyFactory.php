<?php
namespace ZFUtils\View\Helper\Factory;

// Vendor namespaces
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;

// ZFUtils namespaces
use ZFUtils\View\Helper\BootstrapNotify;

/**
 * BootstrapNotifyFactory 
 * Factory to inject the view helper config hard dependency
 * 
 * @uses FactoryInterface
 * @author Rolando Isidoro (https://github.com/rolandoisidoro) 
 */
class BootstrapNotifyFactory implements FactoryInterface
{
    /**
     * createService 
     * Compatibility with ZF2 (>= 2.2) -> proxy to __invoke
     * 
     * @param  ServiceLocatorInterface $oServiceLocator 
     * @param  mixed $sCanonicalName 
     * @param  mixed $sRequestedName 
     * @access public
     * @return void
     */
    public function createService(ServiceLocatorInterface $oServiceLocator, $sCanonicalName = null, $sRequestedName = null)
    {
        return $this($oServiceLocator, $sRequestedName);
    }


    /**
     * __invoke 
     * Compatibility with ZF3
     * 
     * @param  ContainerInterface $container 
     * @param  mixed $requestedName 
     * @param  array $options 
     * @access public
     * @return void
     */
    public function __invoke(ContainerInterface $oContainer, $sRequestedName, array $aOptions = null)
    {
        $aConfig = $oContainer->get('config');

        return new BootstrapNotify($aConfig['zfutils']['boostrap_notify']);
    }
}

