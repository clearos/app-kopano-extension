<?php

/**
 * Kopano OpenLDAP user extension.
 *
 * @category   apps
 * @package    kopano-extension
 * @subpackage libraries
 * @author     ClearCenter <developer@clearcenter.com>
 * @copyright  2012-2013 ClearCenter
 * @license    http://www.clearcenter.com/app_license ClearCenter license
 * @link       http://www.clearcenter.com/support/documentation/clearos/kopano_extension/
 */

///////////////////////////////////////////////////////////////////////////////
// N A M E S P A C E
///////////////////////////////////////////////////////////////////////////////

namespace clearos\apps\kopano_extension;

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('kopano_extension');

///////////////////////////////////////////////////////////////////////////////
// D E P E N D E N C I E S
///////////////////////////////////////////////////////////////////////////////

use \clearos\apps\base\Engine as Engine;
use \clearos\apps\openldap_directory\Utilities as Utilities;

clearos_load_library('base/Engine');
clearos_load_library('openldap_directory/Utilities');

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Kopano OpenLDAP user extension.
 *
 * @category   apps
 * @package    kopano-extension
 * @subpackage libraries
 * @author     ClearCenter <developer@clearcenter.com>
 * @copyright  2012-2013 ClearCenter
 * @license    http://www.clearcenter.com/app_license ClearCenter license
 * @link       http://www.clearcenter.com/support/documentation/clearos/kopano_extension/
 */

class OpenLDAP_User_Extension extends Engine
{
    ///////////////////////////////////////////////////////////////////////////////
    // V A R I A B L E S
    ///////////////////////////////////////////////////////////////////////////////

    protected $info_map = array();

    ///////////////////////////////////////////////////////////////////////////////
    // M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Kopano OpenLDAP_User_Extension constructor.
     */

    public function __construct()
    {
        clearos_profile(__METHOD__, __LINE__);

        include clearos_app_base('kopano_extension') . '/deploy/user_map.php';

        $this->info_map = $info_map;
    }

    /** 
     * Add LDAP attributes hook.
     *
     * @param array $user_info   user information in hash array
     * @param array $ldap_object LDAP object
     *
     * @return array LDAP attributes
     * @throws Engine_Exception
     */

    public function add_attributes_hook($user_info, $ldap_object)
    {
        clearos_profile(__METHOD__, __LINE__);

        // Implied fields
        //---------------

        if (isset($user_info['extensions']['kopano']['hard_quota'])) {
            $user_info['extensions']['kopano']['quota_override'] = 1;
            $user_info['extensions']['kopano']['warning_quota'] = round(0.90 * $user_info['extensions']['kopano']['hard_quota']);
            $user_info['extensions']['kopano']['soft_quota'] = round(0.95 * $user_info['extensions']['kopano']['hard_quota']);
        }

        // Convert attributes
        //-------------------

        $attributes = Utilities::convert_array_to_attributes($user_info['extensions']['kopano'], $this->info_map);

        return $attributes;
    }

    /**
     * Returns user info defaults hash array.
     *
     * @param string $username username
     *
     * @return array user info defaults array
     * @throws Engine_Exception
     */

    public function get_info_defaults_hook($username)
    {
        clearos_profile(__METHOD__, __LINE__);

        $info['hard_quota'] = 10000;
        $info['administrator_flag'] = FALSE;
        $info['account_flag'] = TRUE;

        return $info;
    }

    /**
     * Returns user info hash array.
     *
     * @param array $attributes LDAP attributes
     *
     * @return array user info array
     * @throws Engine_Exception
     */

    public function get_info_hook($attributes)
    {
        clearos_profile(__METHOD__, __LINE__);

        $info = Utilities::convert_attributes_to_array($attributes, $this->info_map);

        return $info;
    }

    /**
     * Returns user info map hash array.
     *
     * @return array user info array
     * @throws Engine_Exception
     */

    public function get_info_map_hook()
    {
        clearos_profile(__METHOD__, __LINE__);

        return $this->info_map;
    }

    /** 
     * Update LDAP attributes hook.
     *
     * @param array $user_info   user information in hash array
     * @param array $ldap_object LDAP object
     *
     * @return array LDAP attributes
     * @throws Engine_Exception
     */

    public function update_attributes_hook($user_info, $ldap_object)
    {
        clearos_profile(__METHOD__, __LINE__);

        // Return if nothing needs to be done
        //-----------------------------------

        if (! isset($user_info['extensions']['kopano']))
            return array();

        // Implied fields
        //---------------

        if (isset($user_info['extensions']['kopano']['hard_quota'])) {
            $user_info['extensions']['kopano']['quota_override'] = 1;
            $user_info['extensions']['kopano']['warning_quota'] = round(0.90 * $user_info['extensions']['kopano']['hard_quota']);
            $user_info['extensions']['kopano']['soft_quota'] = round(0.95 * $user_info['extensions']['kopano']['hard_quota']);
        }

        // Convert to LDAP attributes
        //---------------------------

        $attributes = Utilities::convert_array_to_attributes($user_info['extensions']['kopano'], $this->info_map);

        return $attributes;
    }

    ///////////////////////////////////////////////////////////////////////////////
    // V A L I D A T I O N   M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Validation routine for account flag.
     *
     * @param string $flag account flag
     *
     * @return string error message if account flag is invalid
     */

    public function validate_account_flag($flag)
    {
        clearos_profile(__METHOD__, __LINE__);

        if (! clearos_is_valid_boolean($flag))
            return lang('kopano_extension_account_flag_is_invalid');
    }
    /**
     * Validation routine for administrator flag.
     *
     * @param string $flag administrator flag
     *
     * @return string error message if administrator flag is invalid
     */

    public function validate_administrator_flag($flag)
    {
        clearos_profile(__METHOD__, __LINE__);

        if (! clearos_is_valid_boolean($flag))
            return lang('kopano_extension_administrator_flag_is_invalid');
    }

    /**
     * Validation routine for hard quota size.
     *
     * @param string $size hard quota size
     *
     * @return string error message if hard quota size is invalid
     */

    public function validate_hard_quota($size)
    {
        clearos_profile(__METHOD__, __LINE__);

        if (! preg_match('/^\d+$/', $size))
            return lang('kopano_extension_hard_quota_is_invalid');
    }
}
