<?php
namespace FreePBX\modules\Iaxsettings;
use FreePBX\modules\Backup as Base;

class Backup Extends Base\BackupBase
{
    public function runBackup($id, $transaction)
    {
        $this->addConfigs($this->FreePBX->Iaxsettings->getConfigs());
    }
}