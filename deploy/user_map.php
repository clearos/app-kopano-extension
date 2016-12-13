<?php

/**
 * Contact OpenLDAP user extension.
 *
 * @category   apps
 * @package    kopano-extension
 * @subpackage libraries
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2011 ClearFoundation
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/contact_extension/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Lesser General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('kopano_extension');
clearos_load_language('base');

///////////////////////////////////////////////////////////////////////////////
// C O N F I G
///////////////////////////////////////////////////////////////////////////////

$lang_gb = lang('base_gigabytes');
$lang_mb = lang('base_megabytes');

$info_map = array(
    'account_flag' => array(
        'type' => 'integer',
        'field_type' => 'list',
        'field_options' => array(
            '0' => 'Disabled',
            '1' => 'Enabled',
        ),
        'required' => FALSE,
        'validator' => 'validate_account_flag',
        'validator_class' => 'kopano_extension/OpenLDAP_User_Extension',
        'description' => lang('kopano_extension_account'),
        'object_class' => 'kopano-user',
        'attribute' => 'kopanoAccount' 
    ),

    'administrator_flag' => array(
        'type' => 'integer',
        'field_type' => 'list',
        'field_options' => array(
            '0' => 'Disabled',
            '1' => 'Enabled',
        ),
        'required' => FALSE,
        'validator' => 'validate_administrator_flag',
        'validator_class' => 'kopano_extension/OpenLDAP_User_Extension',
        'description' => lang('kopano_extension_administrator_privileges'),
        'object_class' => 'kopano-user',
        'attribute' => 'kopanoAdmin' 
    ),

    'hard_quota' => array(
        'type' => 'integer',
        'field_type' => 'list',
        'field_options' => array(
            '100' => '100 ' . $lang_mb,
            '250' => '250 ' . $lang_mb,
            '500' => '500 ' . $lang_mb,
            '1000' => '1 ' . $lang_gb,
            '2000' => '2 ' . $lang_gb,
            '3000' => '3 ' . $lang_gb,
            '4000' => '4 ' . $lang_gb,
            '5000' => '5 ' . $lang_gb,
            '10000' => '10 ' . $lang_gb,
            '20000' => '20 ' . $lang_gb,
            '30000' => '30 ' . $lang_gb,
            '40000' => '40 ' . $lang_gb,
            '50000' => '50 ' . $lang_gb,
            '100000' => '100 ' . $lang_gb,
            '0' => lang('base_unlimited')
        ),
        'required' => TRUE,
        'validator' => 'validate_hard_quota',
        'validator_class' => 'kopano_extension/OpenLDAP_User_Extension',
        'description' => lang('kopano_extension_hard_quota'),
        'object_class' => 'kopano-user',
        'attribute' => 'kopanoQuotaHard' 
    ),

    'quota_override' => array(
        'type' => 'integer',
        'field_type' => 'text',
        'field_priority' => 'hidden',
        'required' => FALSE,
        'description' => lang('kopano_extension_quota_override'),
        'object_class' => 'kopano-user',
        'attribute' => 'kopanoQuotaOverride'
    ),

    'soft_quota' => array(
        'type' => 'integer',
        'field_type' => 'text',
        'field_priority' => 'hidden',
        'required' => FALSE,
        'description' => lang('kopano_extension_soft_quota'),
        'object_class' => 'kopano-user',
        'attribute' => 'kopanoQuotaSoft'
    ),

    'warning_quota' => array(
        'type' => 'integer',
        'field_type' => 'text',
        'field_priority' => 'hidden',
        'required' => FALSE,
        'description' => lang('kopano_extension_warning_quota'),
        'object_class' => 'kopano-user',
        'attribute' => 'kopanoQuotaWarn'
    ),
);
