<?php
namespace FreePBX\modules\Iaxsettings;
// vim: set ai ts=4 sw=4 ft=php:
/*
 * License for all code of this FreePBX module can be found in the license file inside the module directory
 * Copyright (c) 2018 Sangoma Technologies
 */

use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $this->FreePBX->Iaxsettings->edit(reset($this->getConfigs()));
  }

  public function processLegacy($pdo, $data, $tables, $unknownTables, $tmpfiledir){
    $tables = array_flip($tables + $unknownTables);
    if (!isset($tables['iaxsettings'])) {
      return $this;
    }
    $bmo = $this->FreePBX->Iaxsettings;
    $bmo->setDatabase($pdo);
    $data = $bmo->getConfigs();
    $this->transformLegacyKV($pdo, 'iaxsettings', $this->FreePBX)
      ->transformNamespacedKV($pdo, 'iaxsettings', $this->FreePBX);
    $bmo->resetDatabase();
    $bmo->edit(reset($data));
    return $this;
  }
}
