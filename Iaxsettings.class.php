<?php
namespace FreePBX\modules;
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015 Sangoma Technologies.
//
class Iaxsettings implements \BMO {
	public function __construct($freepbx = null) {
		if ($freepbx == null) {
			throw new Exception("Not given a FreePBX Object");
		}

		$this->FreePBX = $freepbx;
		$this->db = $freepbx->Database;
	}

	public function doConfigPageInit($page) {
		$request = $_REQUEST;
		$error_displays = array();
		$action                            = isset($request['action'])?$request['action']:'';
		$post_codec = isset($request['codec']) ? $request['codec'] : array();
		$post_vcodec = isset($request['vcodec']) ? $request['vcodec'] : array();
		$iax_settings['codecpriority']     = isset($request['codecpriority']) ? $request['codecpriority'] : 'host';
		$iax_settings['bandwidth']         = isset($request['bandwidth']) ? $request['bandwidth'] : 'unset';
		$iax_settings['videosupport']      = isset($request['videosupport']) ? $request['videosupport'] : 'no';

		$iax_settings['maxregexpire']      = isset($request['maxregexpire']) ? htmlspecialchars($request['maxregexpire']) : '3600';
		$iax_settings['minregexpire']      = isset($request['minregexpire']) ? htmlspecialchars($request['minregexpire']) : '60';

		$iax_settings['jitterbuffer']      = isset($request['jitterbuffer']) ? $request['jitterbuffer'] : 'no';
		$iax_settings['forcejitterbuffer'] = isset($request['forcejitterbuffer']) ? $request['forcejitterbuffer'] : 'no';
		$iax_settings['maxjitterbuffer']   = isset($request['maxjitterbuffer']) ? htmlspecialchars($request['maxjitterbuffer']) : '200';
		$iax_settings['resyncthreshold']   = isset($request['resyncthreshold']) ? htmlspecialchars($request['resyncthreshold']) : '1000';
		$iax_settings['maxjitterinterps']  = isset($request['maxjitterinterps']) ? htmlspecialchars($request['maxjitterinterps']) : '10';

		$iax_settings['bindaddr']          = isset($request['bindaddr']) ? htmlspecialchars($request['bindaddr']) : '';
		$iax_settings['bindport']          = isset($request['bindport']) ? htmlspecialchars($request['bindport']) : '';
		$iax_settings['delayreject']       = isset($request['delayreject']) ? htmlspecialchars($request['delayreject']) : 'yes';
		$codecs = array(
			'ulaw'     => '',
			'alaw'     => '',
			'slin'     => '',
			'g726'     => '',
			'gsm'      => '',
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
		  // With the new sorting, the vars should come to us in the sorted order so just use that
		  //
		$pri = 1;
		foreach (array_keys($post_codec) as $codec) {
			$codecs[$codec] = $pri++;
		}
		$iax_settings['codecs']	= $codecs;

		$video_codecs = array(
			'h261'  => '',
			'h263'  => '',
			'h263p' => '',
			'h264'  => '',
		);

		$pri = 1;
		foreach (array_keys($post_vcodec) as $vcodec) {
			$video_codecs[$vcodec] = $pri++;
		}
		$iax_settings['video_codecs']      = $video_codecs;

		$p_idx = $n_idx = 0;
		while (isset($request["iax_custom_key_$p_idx"])) {
			if ($request["iax_custom_key_$p_idx"] != '') {
				$iax_settings["iax_custom_key_$n_idx"] = htmlspecialchars($request["iax_custom_key_$p_idx"]);
				$iax_settings["iax_custom_val_$n_idx"] = htmlspecialchars($request["iax_custom_val_$p_idx"]);
				$n_idx++;
			}
			$p_idx++;
		}
		switch ($action) {
			case "edit":  //just delete and re-add
				if (($errors = iaxsettings_edit($iax_settings)) !== true) {
					$error_displays = process_errors($errors);
				} else {
					needreload();
					//redirect_standard();
				}
			break;
			default:
				/* only get them if first time load, if they pressed submit, use values from POST */
				$iax_settings = iaxsettings_get();
		}
		$error_displays = array_merge($error_displays,iaxsettings_check_custom_files());

	}

	public function install() {

	}
	public function uninstall() {

	}
	public function backup(){

	}
	public function restore($backup){

	}
	public function getActionBar($request) {
		switch ($request['display']) {
			case 'iaxsettings':
				$buttons = array(
						'submit' => array(
							'name' => 'submit',
							'id' => 'submit',
							'value' => _("Submit")
						),
						'reset' => array(
							'name' => 'reset',
							'id' => 'reset',
							'value' => _("Reset")
						),
					);
				return $buttons;
			break;
		}
	}
}
