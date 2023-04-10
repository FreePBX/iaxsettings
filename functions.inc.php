<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
/* $Id:$ */
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2013 Schmooze Com Inc.
//

// Use hookGet_config so that everyone (like core) will have written their
// IAX settings and then we can remove any that we are going to override

include_once __DIR__ . '/iaxsettings_validate.class.php';

function iaxsettings_get($raw=false)
{
    \FreePBX::Modules()->deprecatedFunction();
    return \FreePBX::Iaxsettings()->getConfigs($raw);
}

// Add a iaxsettings
function iaxsettings_edit($iax_settings)
{
    \FreePBX::Modules()->deprecatedFunction();
    return \FreePBX::Iaxsettings()->edit($iax_settings);
}

function iaxsettings_check_custom_files()
{
    \FreePBX::Modules()->deprecatedFunction();
    return \FreePBX::Iaxsettings()->check_custom_files();
}