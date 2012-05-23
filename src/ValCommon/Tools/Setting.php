<?php
namespace ValCommon\Tools;

/**
 * ValCommon - Setting Manager
 *
 * Provides a simple static setting manager.
 *
 * @package     ValCommon
 * @subpackage  ValCommon\Tools\Setting
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Setting
{
    /**
     * @var Array
     */
    static protected $_aDefaults = Array();


    /**
     * Retrieve Setting Value
     *
     * @param  String $sKey     Setting Key name
     * @param  String $sDefault Default value if not found
     * @return String
     */
    static public function get($sKey, $sDefault = null)
    {
        /**
         * Check for key
         */
        if (isset(self::$_aDefaults[$sKey])) {
            return self::$_aDefaults[$sKey];
        }


        return $sDefault;
    }


    /**
     * Set the default setting values
     *
     * @param Array $aDefaults Default values
     */
    static public function setDefaults($aDefaults)
    {
        self::$_aDefaults = $aDefaults;
    }
}
