<?php
namespace ValCommon;
use ValCommon\Tools\Setting,
    Zend\Module\Manager,
    Zend\EventManager\Event,
    Zend\Module\Consumer\AutoloaderProvider;

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
class Module implements AutoloaderProvider
{
    /**
     * Initiate the module
     *
     * @param   Manager $oManager
     */
    public function init(Manager $oManager)
    {
        /**
         * Register Event for CSS Compile Process
         */
        $oEvents = $oManager->events()->getSharedManager();
        $oEvents->attach(
            'bootstrap', 'bootstrap', Array($this, 'compileCss')
        );


        /**
         * Register event to save default settings
         */
        $oEvents = $oManager->events()->getSharedManager();
        $oEvents->attach(
            'bootstrap', 'bootstrap', Array($this, 'initSettings')
        );
    }


    /**
     * Compile the LESS into CSS in development mode
     *
     * @param   Event   $oEvent Triggered Event information
     */
    public function compileCss(Event $oEvent)
    {
        /**
         * Check we have CSS config information
         */
        $oConfig = $oEvent->getParam('config');
        if (!isset($oConfig->valcommon) || !isset($oConfig->valcommon->css)) {
            return;
        }
        $oConfig = $oConfig->valcommon->css;


        /**
         * Check compile flag
         */
        $oRequest = $oEvent->getParam('application')->getRequest();
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
     * @param   Event   $oEvent Triggered Event information
     */
    public function initSettings(Event $oEvent)
    {
        /**
         * Check we have default settings
         */
        $oConfig = $oEvent->getParam('config');
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
