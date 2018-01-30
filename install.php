<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
/* $Id:$ */

global $db;
global $amp_conf;

$sql = <<< END
CREATE TABLE IF NOT EXISTS `iaxsettings` (
  `keyword` VARCHAR (50) NOT NULL default '',
  `data`    VARCHAR (255) NOT NULL default '',
  `seq`     TINYINT (1),
  `type`    TINYINT (1) NOT NULL default '0',
  PRIMARY KEY (`keyword`,`seq`,`type`)
)
END;

outn(_("checking for iaxsettings table.."));
$tsql = "SELECT * FROM `iaxsettings` limit 1";
$check = $db->getRow($tsql, DB_FETCHMODE_ASSOC);
if(DB::IsError($check)) {
	out(_("none, creating table"));
	// table does not exist, create it
	sql($sql);

	outn(_("populating default codecs.."));
  $sip_settings =  array(
    array('ulaw'    ,'1', '0'),
    array('alaw'    ,'2', '1'),
    array('slin'    ,'' , '2'),
    array('g726'    ,'' , '3'),
    array('gsm'     ,'3', '4'),
    array('g729'    ,'' , '5'),
    array('ilbc'    ,'' , '6'),
    array('g723'    ,'' , '7'),
    array('g726aal2','' , '8'),
    array('adpcm'   ,'' , '9'),
    array('lpc10'   ,'' ,'10'),
    array('speex'   ,'' ,'11'),
    array('g722'    ,'' ,'12'),
    );

	// Now insert minimal codec rows
	$compiled = $db->prepare("INSERT INTO iaxsettings (keyword, data, seq, type) values (?,?,?,'1')");
	$result = $db->executeMultiple($compiled,$sip_settings);
	if(DB::IsError($result)) {
		out(_("fatal error occurred populating defaults, check module"));
	} else {
		out(_("ulaw, alaw, gsm added"));
	}
} else {
	out(_("already exists"));
}

/* Convert language to custom field */
$sql = "SELECT MAX(seq) FROM iaxsettings WHERE type = 9";
$seq = sql($sql,'getOne');
$sql = "UPDATE iaxsettings SET keyword = 'language', type = 9, seq = " . ($seq !== NULL ? $seq + 1 : 0) . " WHERE keyword = 'iax_language'";
sql($sql);

// Setting up default value.
$iax_settings['codecpriority']     = 'host';
$iax_settings['bandwidth']         = 'unset';
$iax_settings['videosupport']      = 'no';
$iax_settings['maxregexpire']      = '3600';
$iax_settings['minregexpire']      = '60';
$iax_settings['jitterbuffer']      = 'no';
$iax_settings['forcejitterbuffer'] = 'no';
$iax_settings['maxjitterbuffer']   = '200';
$iax_settings['resyncthreshold']   = '1000';
$iax_settings['maxjitterinterps']  = '10';
$iax_settings['bindaddr']          = '';
$iax_settings['bindport']          = '';
$iax_settings['delayreject']       = 'yes';
$codecs = array(		'ulaw'     => '1',
						'alaw'     => '2',
						'slin'     => '',
						'g726'     => '',
						'gsm'      => '3',
						'g729'     => '',
						'ilbc'     => '',
						'g723'     => '',
						'g726aal2' => '',
						'adpcm'    => '',
						'lpc10'    => '',
						'speex'    => '',
						'g722'     => '',
						'siren7'   => '',
						'siren14'  => '',
				);
$iax_settings['codecs']			   = $codecs;
$video_codecs = array(	'h261'     => '',
						'h263'     => '',
						'h263p'    => '',
						'h264'     => '',
					);
$iax_settings['video_codecs']      = $video_codecs;

Freepbx::Iaxsettings()->edit($iax_settings);