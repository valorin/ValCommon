<?php
namespace ValCommon;
use ValCommon\Tools\Setting,
    Zend\Mvc\MvcEvent;

/**
 * ValCommon - ZF2 Common Tools Module
 *
 * Provides common/useful tools for ZF2 applications.
 *
 * @package     ValCommon
 * @subpackage  ValCommon\Module
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Module
{
    /**
     * Run Bootstrap Functionality
     *
     * @param MvcEvent $event Bootstrap Event
     */
    public function onBootstrap(MvcEvent $event)
    {
        /**
         * Run the CSS Compile Process
         */
        $this->_compileCss($event);


        /**
         * Save default settings
         */
        $this->_initSettings($event);
    }


    /**
     * Compile the LESS into CSS in development mode
     *
     * @param MvcEvent $event MVC Bootstrap Event
     */
    protected function _compileCss(MvcEvent $event)
    {
        /**
         * Check we have CSS config information
         */
        $oConfig = $event->getApplication()->getConfiguration();
        if (!isset($oConfig->valcommon) || !isset($oConfig->valcommon->css)) {
            return;
        }
        $oConfig = $oConfig->valcommon->css;


        /**
         * Check compile flag
         */
        $oRequest = $event->getRequest();
        if (!$oRequest->query()->get('compileCss')) {
            return;
        }


        /**
         * Import the LessPHP library
         */
        require_once __DIR__ . "/src/lessphp/lessc.inc.php";


        /**
         * Define the files
         */
        $oLessc = new \lessc($oConfig->less);
        file_put_contents($oConfig->css, $oLessc->parse());
    }


    /**
     * Initiate the settings module
     *
     * @param MvcEvent $event MVC Bootstrap Event
     */
    protected function _initSettings(MvcEvent $event)
    {
        /**
         * Check we have default settings
         */
        $oConfig = $event->getApplication()->getConfiguration();
        if (!isset($oConfig->valcommon)
            || !isset($oConfig->valcommon->setting)) {
            return;
        }


        /**
         * Save in Settings manager
         */
        Setting::setDefaults($oConfig->valcommon->setting);
    }


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
