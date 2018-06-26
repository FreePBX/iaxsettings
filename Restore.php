<?php
namespace FreePBX\modules\Iaxsettings;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $this->FreePBX->Iaxsettings->edit($this->getConfigs());
  }
}