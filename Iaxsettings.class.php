<?php
namespace FreePBX\modules;
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015-2018 Sangoma Technologies.
//
use BMO;
use PDO;
use \Respect\Validation\Validator;
class Iaxsettings implements BMO {
	/* Field Values for type field */
	const IAX_NORMAL      = '0';
	const IAX_CODEC       = '1';
	const IAX_VIDEO_CODEC = '2';
	const IAX_CUSTOM 			= '9';

	public function __construct($freepbx = null) {
		if ($freepbx == null) {
			throw new Exception("Not given a FreePBX Object");
		}
		$this->errors = array();
		$this->FreePBX = $freepbx;
		$this->db = $freepbx->Database;
		$this->v = new Validator();
	}

	public function doConfigPageInit($page) {

	}

	public function install() {
        outn(_("populating default settings.."));
        $this->edit($this->getDefaults());
	}
	public function uninstall() {

	}
	public function setDatabase($database){
		$this->db = $database;
		return $this;
	}
	public function resetDatabase(){
		$this->db = $this->FreePBX->Database;
		return this;
	}
    
    public function getDefaults(){
        return [
            'codecs' => $this->FreePBX->Codecs->getAudio(true),
            'video_codecs' => $this->FreePBX->Codecs->getVideo(true),
            'codecpriority' =>'host',
            'bandwidth' =>'unset',
            'videosupport' =>'no',
            'minregexpire' =>'60',
            'maxregexpire' =>'3600',
            'jitterbuffer' =>'no',
            'forcejitterbuffer' =>'no',
            'maxjitterbuffer' =>'200',
            'resyncthreshold' =>'1000',
            'maxjitterinterps' =>'10',
            'bindaddr' =>'',
            'bindport' =>'',
            'delayreject' =>'yes',
            'iax_custom_key_0' =>'',
            'iax_custom_val_0' =>'',
        ];
    }

	public function getActionBar($request) {
		switch ($request['display']) {
			case 'iaxsettings':
				$buttons = array(
						'submit' => array(
							'name' => 'ajaxsubmit',
							'id' => 'ajaxsubmit',
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
	public function showPage(){
		return load_view(__DIR__.'/views/form.php', array('request' => $_REQUEST, $errors = $this->errors));
	}
	public function edit($iax_settings, $validateonly = false){
		$save_settings = array();
		$codecs = $iax_settings['codecs'];
		$video_codecs = $iax_settings['video_codecs'];
		unset($iax_settings['codecs']);
		unset($iax_settings['video_codecs']);
		$integer_msg = _("%s must be a non-negative integer");
		$errors = [];
		foreach ($iax_settings as $key => $val) {
			$val = trim($val);
			switch ($key) {
				case 'bindaddr':
					if(filter_var($val,FILTER_VALIDATE_IP) !== false){
						$save_settings[] = array($key,$val,'2',self::IAX_NORMAL);
					}else{
						if(!empty($val)){
							$errors[] = _("Bind Address (bindaddr) must be an IP address.");
						}
					}
				break;

				case 'bindport':
					if($this->v->IntVal()->between(1024, 65535)->validate($val)){
						$save_settings[] = array($key,$val,'1',self::IAX_NORMAL);
					}else{
						if(!empty($val)){
							$errors[] = _("Bind Port (bindport) must be between 1024..65535, default 4569");
						}
					}
				break;

				case 'minregexpire':
				case 'maxregexpire':
					if($this->v->IntVal()->positive()->validate($val)){
						$save_settings[] = array($key,$val,'10',self::IAX_NORMAL);
					}else{
						$errors[] = sprintf($integer_msg,$key);
					}
				break;
				case 'codecpriority':
				case 'delayreject':
				case 'bandwidth':
					$save_settings[] = array($key,$val,'0',self::IAX_NORMAL);
				break;

				case 'jitterbuffer':
					$save_settings[] = array($key,$val,'4',self::IAX_NORMAL);
				break;

				case 'forcejitterbuffer':
					$save_settings[] = array($key,$val,'5',self::IAX_NORMAL);
				break;

				case 'maxjitterbuffer':
				case 'maxjitterinterps':
					if($this->v->IntVal()->positive()->validate($val)){
						$save_settings[] = array($key,$val,'5',self::IAX_NORMAL);
					}else{
						$errors[] = sprintf($integer_msg,$key);
					}
				break;

				case 'resyncthreshold':
					if($this->v->IntVal()->validate($val) || $val == -1){
						$save_settings[] = array($key,$val,'5',self::IAX_NORMAL);
					}else{
						$errors[] = _("resyncthreshold must be a non-negative integer or -1 to disable");
					}
				break;

				case 'videosupport':
					$save_settings[] = array($key,$val,'10',self::IAX_NORMAL);
				break;

			default:
				if (substr($key,0,15) == "iax_custom_key_") {
					$seq = substr($key,15);
					$save_settings[] = array($val,$iax_settings["iax_custom_val_$seq"],($seq),self::IAX_CUSTOM);
				} else if (substr($key,0,15) == "iax_custom_val_") {
					// skip it, we will seek it out when we see the iax_custom_key
				} else {
					$save_settings[] = array($key,$val,'0',self::IAX_NORMAL);
				}
			}
		}
		if (count($errors)) {
	    return $errors;
	  } else {
			if($validateonly === true){
				return true;
			}
	    $seq = 0;
	    if (!empty($codecs)) {
	        foreach ($codecs as $key => $val) {
	          $save_settings[] = array($key,$val,$seq++,self::IAX_CODEC);
	        }
	    }
	    $seq = 0;
	    if (!empty($video_codecs)) {
	        foreach ($video_codecs as $key => $val) {
	          $save_settings[] = array($key,$val,$seq++,self::IAX_VIDEO_CODEC);
	        }
	    }

	    // TODO: normally don't like doing delete/insert but otherwise we would have do update for each
	    //       individual setting and then an insert if there was nothing to update. So this is cleaner
	    //       this time around.
		  //
			$sql = 'truncate iaxsettings';
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$stmt = $this->db->prepare('INSERT INTO `iaxsettings` (`keyword`, `data`, `seq`, `type`) VALUES (?,?,?,?)');
			foreach ($save_settings as $key => $value) {
				if(!$stmt->execute($value)){
					$ei = $stmt->errorInfo();
					$errors[] = $ei[2];
				}
			}
			if(!empty($errors)){
				return $errors;
			}
	    return true;
	  }
	}
	public function ajaxRequest($req, &$setting) {
		switch ($req) {
			case 'savesettings':
				return true;
			break;
		}
		return false;
	}
	public function ajaxHandler(){
		switch ($_REQUEST['command']) {
			case 'savesettings':
				$request = $_REQUEST;
				$action = isset($request['action'])?$request['action']:'';
				if ($action == "edit") {
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
					$errors = $this->edit($iax_settings);
					if (is_array($errors)) {
						return array('status' => false, 'message' => $errors);
					} else {
						needreload();
						return array('status' => true, 'message' => 'saved');
					}
				}
			break;
		}
    }

    function getConfigs($raw = false){

        $sql = "SELECT `keyword`, `data`, `type`, `seq` FROM `iaxsettings` ORDER BY `type`, `seq`";
        $raw_settings = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

          /* Just give the SQL table if more convenient (such as in hookGet_config */
        if ($raw) {
            return $raw_settings;
        }

        /* Initialize first, then replace with DB, to make sure we have defaults */
        $iax_settings = $this->getDefaults();

        foreach ($raw_settings as $var) {
            switch ($var['type']) {
                case IAX_NORMAL:
                    $iax_settings[$var['keyword']] = $var['data'];
                    break;

                case IAX_CODEC:
                    $iax_settings['codecs'][$var['keyword']] = $var['data'];
                    break;

                case IAX_VIDEO_CODEC:
                    $iax_settings['video_codecs'][$var['keyword']] = $var['data'];
                    break;

                case IAX_CUSTOM:
                    $iax_settings['iax_custom_key_' . $var['seq']] = $var['keyword'];
                    $iax_settings['iax_custom_val_' . $var['seq']] = $var['data'];
                    break;

                default:
                    break;
            }
        }
        unset($raw_settings);

        return $iax_settings;
    }
}
