<?php
namespace FreePBX\modules\Iaxsettings;
// vim: set ai ts=4 sw=4 ft=php:
/*
 * License for all code of this FreePBX module can be found in the license file inside the module directory
 * Copyright (c) 2018 Sangoma Technologies
 */

use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
	public function runRestore(){
		$this->FreePBX->Iaxsettings->edit(reset($this->getConfigs()));
	}

	public function processLegacy($pdo, $data, $tables, $unknownTables){
		$this->restoreLegacyDatabase($pdo);
	}
}
