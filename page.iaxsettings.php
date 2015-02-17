<?php /* $Id:$ */
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
//  License for all code of this FreePBX module can be found in the license file inside the module directory
//  Copyright 2015 Sangoma Technologies.
//
?>
<div class="container-fluid">
  <h1><?php echo _('IAX Settings')?></h1>
  <div class = "display full-border">
    <div class="row">
      <div class="col-sm-11">
        <div class="fpbx-container">
          <div class="display full-border">
            <?php echo load_view(__DIR__.'/views/form.php', array('request' => $_REQUEST));?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="/admin/modules/iaxsettings/assets/js/iaxsettings.js"></script>