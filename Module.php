<?php
namespace ValCommon;
use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider;

/**
 * ValCommon - ZF2 Common Tools Module
 *
 * Provides common/useful tools for ZF2 applications.
 *
 * @package     ValCommon
 * @subpackage  ValCommon_Module
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Module implements AutoloaderProvider
{
    /**
     * Autoloader config
     *
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


    /**
     * Get module config
     *
     */
    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
