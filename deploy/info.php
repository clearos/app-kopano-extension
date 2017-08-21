<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'kopano_extension';
$app['version'] = '2.3.2';
$app['release'] = '1';
$app['vendor'] = 'ClearCenter';
$app['packager'] = 'ClearCenter';
$app['license'] = 'ClearCenter';
$app['license_core'] = 'ClearCenter';
$app['description'] = lang('kopano_extension_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('kopano_extension_app_name');
$app['category'] = lang('base_category_server');
$app['subcategory'] = lang('base_subcategory_directory');
$app['menu_enabled'] = FALSE;

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['core_only'] = TRUE;

$app['core_requires'] = array(
    'app-contact-extension-core',
    'app-mail-extension-core',
    'app-openldap-core >= 1:2.2.0',
    'app-openldap-directory-core',
    'app-smtp-plugin-core',
    'app-users',
);

$app['core_file_manifest'] = array( 
   'kopano.php' => array(
        'target' => '/var/clearos/openldap_directory/extensions/70_kopano.php'
    ),
);

$app['delete_dependency'] = array();
