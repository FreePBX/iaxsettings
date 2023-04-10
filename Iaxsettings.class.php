<?php
namespace FreePBX\modules;
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015-2018 Sangoma Technologies.
//
use BMO;
use PDO;
use \Respect\Validation\Validator;
class Iaxsettings implements BMO
{
	/* Field Values for type field */
	const IAX_NORMAL      = '0';
	const IAX_CODEC       = '1';
	const IAX_VIDEO_CODEC = '2';
	const IAX_CUSTOM 	  = '9';

	const TABLE_SETTINGS  = 'iaxsettings';

	protected $errors = array();
	protected $FreePBX;
	protected $db;
	protected $config;
	protected $validator;

	public function __construct($freepbx = null)
	{
		if ($freepbx == null)
		{
			throw new \Exception("Not given a FreePBX Object");
		}
		$this->errors 	 = array();
		$this->FreePBX 	 = $freepbx;
		$this->db 		 = $freepbx->Database;
		$this->config 	 = $freepbx->Config;
		$this->validator = new Validator();
	}

	public function doConfigPageInit($page) { }

	public function install()
	{
        outn(_("populating default settings.."));
        $this->edit($this->getDefaults());
	}
	
	public function uninstall() { }

	public function setDatabase($database)
	{
		$this->db = $database;
		return $this;
	}

	public function resetDatabase()
	{
		$this->db = $this->FreePBX->Database;
		return $this;
	}
    
    public function getDefaults()
	{
        return [
            'codecs' 			=> $this->FreePBX->Codecs->getAudio(true),
            'video_codecs' 		=> $this->FreePBX->Codecs->getVideo(true),
            'codecpriority' 	=>'host',
            'bandwidth' 		=>'unset',
            'videosupport' 		=>'no',
            'minregexpire' 		=>'60',
            'maxregexpire' 		=>'3600',
            'jitterbuffer' 		=>'no',
            'forcejitterbuffer' =>'no',
            'maxjitterbuffer' 	=>'200',
            'resyncthreshold' 	=>'1000',
            'maxjitterinterps' 	=>'10',
            'bindaddr' 			=>'',
            'bindport' 			=>'',
            'delayreject' 		=>'yes',
            'iax_custom_key_0' 	=>'',
            'iax_custom_val_0' 	=>'',
        ];
    }

	public function getActionBar($request)
	{
		switch ($request['display'])
		{
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

	public function showPage($page, $params = array())
	{
		$request = $_REQUEST;
		$data = array(
			"iaxsettings" => $this,
			'request' 	  => $request,
			'page' 	  	  => $page,
		);
		$data = array_merge($data, $params);
		switch ($page)
		{
			case 'main':
				$data['errors'] 	= $this->errors;
				$data_return = load_view(__DIR__."/views/page.main.php", $data);
				break;

			case 'form_options':
				$data['errors'] 	= $this->errors;
				$data['settings'] 	= $this->getConfigs(false);
				$data_return = load_view(__DIR__."/views/view.form_options.php", $data);
				break;

			default:
				$data_return = sprintf(_("Page Not Found (%s)!!!!"), $page);
		}
		return $data_return;
	}

	public function edit($iax_settings, $validateonly = false)
	{
		$save_settings 	= array();
		$codecs 		= $iax_settings['codecs'];
		$video_codecs 	= $iax_settings['video_codecs'];
		unset($iax_settings['codecs']);
		unset($iax_settings['video_codecs']);
		$integer_msg = _("%s must be a non-negative integer");

		$errors = [];
		foreach ($iax_settings as $key => $val)
		{
			$val = trim($val);
			switch ($key)
			{
				case 'bindaddr':
					if(filter_var($val, FILTER_VALIDATE_IP) !== false)
					{
						$save_settings[] = array($key, $val, '2', self::IAX_NORMAL);
					}
					else
					{
						if(!empty($val))
						{
							$errors[] = _("Bind Address (bindaddr) must be an IP address.");
						}
					}
				break;

				case 'bindport':
					if($this->validator->IntVal()->between(1024, 65535)->validate($val))
					{
						$save_settings[] = array($key, $val, '1', self::IAX_NORMAL);
					}
					else
					{
						if(!empty($val))
						{
							$errors[] = _("Bind Port (bindport) must be between 1024..65535, default 4569");
						}
					}
				break;

				case 'minregexpire':
				case 'maxregexpire':
					if($this->validator->IntVal()->positive()->validate($val))
					{
						$save_settings[] = array($key, $val, '10', self::IAX_NORMAL);
					}
					else
					{
						$errors[] = sprintf($integer_msg,$key);
					}
				break;
				case 'codecpriority':
				case 'delayreject':
				case 'bandwidth':
					$save_settings[] = array($key, $val, '0', self::IAX_NORMAL);
				break;

				case 'jitterbuffer':
					$save_settings[] = array($key, $val, '4', self::IAX_NORMAL);
				break;

				case 'forcejitterbuffer':
					$save_settings[] = array($key, $val, '5', self::IAX_NORMAL);
				break;

				case 'maxjitterbuffer':
				case 'maxjitterinterps':
					if($this->validator->IntVal()->positive()->validate($val))
					{
						$save_settings[] = array($key, $val, '5', self::IAX_NORMAL);
					}
					else
					{
						$errors[] = sprintf($integer_msg, $key);
					}
				break;

				case 'resyncthreshold':
					if($this->validator->IntVal()->validate($val) || $val == -1)
					{
						$save_settings[] = array($key, $val, '5', self::IAX_NORMAL);
					}
					else
					{
						$errors[] = _("resyncthreshold must be a non-negative integer or -1 to disable");
					}
				break;

				case 'videosupport':
					$save_settings[] = array($key, $val, '10', self::IAX_NORMAL);
				break;

			default:
				if (substr($key,0,15) == "iax_custom_key_")
				{
					$seq = substr($key,15);
					$save_settings[] = array($val, $iax_settings["iax_custom_val_$seq"], ($seq), self::IAX_CUSTOM);
				}
				else if (substr($key,0,15) == "iax_custom_val_")
				{
					// skip it, we will seek it out when we see the iax_custom_key
				}
				else
				{
					$save_settings[] = array($key, $val, '0', self::IAX_NORMAL);
				}
			}
		}
		if (count($errors))
		{
	    	return $errors;
	  	}
		else
		{
			if($validateonly === true)
			{
				return true;
			}
	    	$seq = 0;
			if (!empty($codecs))
			{
				foreach ($codecs as $key => $val)
				{
					$save_settings[] = array($key, $val, $seq++, self::IAX_CODEC);
				}
			}
	    	$seq = 0;
	    	if (!empty($video_codecs))
			{
	        	foreach ($video_codecs as $key => $val)
				{
	          		$save_settings[] = array($key, $val, $seq++, self::IAX_VIDEO_CODEC);
	        	}
	    	}

			// TODO: normally don't like doing delete/insert but otherwise we would have do update for each
			//       individual setting and then an insert if there was nothing to update. So this is cleaner
			//       this time around.
			//
			$sql =  sprintf('truncate %s', self::TABLE_SETTINGS);
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			$sql =  sprintf('INSERT INTO `%s` (`keyword`, `data`, `seq`, `type`) VALUES (?,?,?,?)', self::TABLE_SETTINGS);
			$stmt = $this->db->prepare($sql);
			foreach ($save_settings as $key => $value)
			{
				if(!$stmt->execute($value))
				{
					$ei = $stmt->errorInfo();
					$errors[] = $ei[2];
				}
			}
			if(!empty($errors))
			{
				return $errors;
			}
	    	return true;
	  	}
	}

	public function ajaxRequest($req, &$setting)
	{
		// ** Allow remote consultation with Postman **
		// ********************************************
		// $setting['authenticate'] = false;
		// $setting['allowremote'] = true;
		// return true;
		// ********************************************
		switch ($req)
		{
			case 'savesettings':
				return true;
				break;

			default:
				return false;
		}
	}

	public function ajaxHandler()
	{
		$request = $_REQUEST;
		$command = isset($request['command']) ? trim($request['command']) : '';

		switch ($command)
		{
			case 'savesettings':
				$action = isset($request['action']) ? $request['action'] : '';
				if ($action == "edit")
				{
					$post_codec  		= isset($request['codec'])  ? $request['codec']  : array();
					$post_vcodec 		= isset($request['vcodec']) ? $request['vcodec'] : array();

					$codecs_all 		= $this->FreePBX->Codecs->getAll();
					$default_settings 	= $this->getDefaults();
					$ls_settins 		= array(
						'codecpriority' 	=> false,
						'bandwidth' 		=> false,
						'videosupport' 		=> false,
						'minregexpire' 		=> true,
						'maxregexpire' 		=> true,
						'jitterbuffer' 		=> false,
						'forcejitterbuffer' => false,
						'maxjitterbuffer' 	=> true,
						'resyncthreshold' 	=> true,
						'maxjitterinterps' 	=> true,
						'bindaddr' 			=> true,
						'bindport' 			=> true,
						'delayreject' 		=> true,
					);

					foreach ($ls_settins as $key => $val)
					{
						$iax_settings[$key] = isset($request[$key]) ? $request[$key] : $default_settings[$key];
						if ($val == true)
						{
							htmlspecialchars($iax_settings[$key]);
						}
					}
					
					// With the new sorting, the vars should come to us in the sorted order so just use that
					// We use the codecs get idols from the codecs class since in the previous way the new codecs are not detected.
					$pri = 1;
					foreach (array_keys($post_codec) as $codec)
					{
						if (! array_key_exists($codec, $codecs_all['audio']))	// Skip the codec not supported.
						{
							continue;
						}
						$codecs_all['audio'][$codec] = $pri++;
					}
					$iax_settings['codecs']	= $codecs_all['audio'];


					$pri = 1;
					foreach (array_keys($post_vcodec) as $vcodec)
					{
						if (! array_key_exists($vcodec, $codecs_all['video']))	// Skip the codec not supported.
						{
							continue;
						}
						$codecs_all['video'][$vcodec] = $pri++;
					}
					$iax_settings['video_codecs'] = $codecs_all['video'];

					
					$n_idx = 0;
					foreach ($request as $k => $v)
					{
						if (empty($v) || is_array($v)) { continue; }
						if (preg_match('/^iax_custom_key_(\d+)$/', $k, $matches))
						{
							$idx = $matches[1];
							$iax_settings["iax_custom_key_$n_idx"] = htmlspecialchars($request["iax_custom_key_$idx"]);
							$iax_settings["iax_custom_val_$n_idx"] = htmlspecialchars($request["iax_custom_val_$idx"]);
							$n_idx++;
						}
					}
					$errors = $this->edit($iax_settings);

					if (is_array($errors))
					{
						$retrun_data = array('status' => false, 'message' => $errors, 'needreload' => false);
					}
					else
					{
						needreload();
						$retrun_data = array('status' => true, 'message' => 'saved', 'needreload' => true);
					}
				}
			break;

			default:
				$retrun_data = array("status" => false, "message" => _("Command not found!"), "command" => $command);
		}

		return $retrun_data;
    }

    public function getConfigs($raw = false)
	{
        $sql = sprintf("SELECT `keyword`, `data`, `type`, `seq` FROM `%s` ORDER BY `type`, `seq`", SELF::TABLE_SETTINGS);
        $raw_settings = $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        /* Just give the SQL table if more convenient (such as in hookGet_config */
        if ($raw)
		{
            return $raw_settings;
        }

        /* Initialize first, then replace with DB, to make sure we have defaults */
        $iax_settings = $this->getDefaults();

        foreach ($raw_settings as $var)
		{
            switch ($var['type'])
			{
                case self::IAX_NORMAL:
                    $iax_settings[$var['keyword']] = $var['data'];
                    break;

                case self::IAX_CODEC:
                    $iax_settings['codecs'][$var['keyword']] = $var['data'];
                    break;

                case self::IAX_VIDEO_CODEC:
                    $iax_settings['video_codecs'][$var['keyword']] = $var['data'];
                    break;

                case self::IAX_CUSTOM:
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

	public function check_custom_files()
	{
		$errors   	  = array();
		$custom_files = array(
			"iax_general_custom.conf",
			"iax_custom.conf"
		);
		foreach ($custom_files as $file)
		{
			$fullpath = sprintf("%s/%s", $this->config->get('ASTETCDIR'), $file);
			if (file_exists($fullpath))
			{
				$iax_conf = @parse_ini_file($fullpath, true);
				foreach ($iax_conf as $section => $item)
				{
					// If setting is an array, then it is a subsection
					//
					if (!is_array($item))
					{
						$msg =  sprintf(_("Settings in %s may override these. Those settings should be removed."), "<b>$file</b>");
						$errors[] = array(
							'js' => '',
							'div' => $msg
						);
						break;
					}
				}
			}
		}
		return $errors;
	}


	/**
	 * Dialplan hooks
	 */
	public function myDialplanHooks()
	{
		return true;
	}

	public function doDialplanHook(&$ext, $engine, $priority)
	{
		global $core_conf;

		if ($engine != "asterisk") { return true; }

      	if (isset($core_conf) && is_a($core_conf, "core_conf"))
		{
        	$raw_settings = $this->getConfigs(true);
        	$codecs = [];
        	/* TODO: This is example concept code
           			 The only real conflicts are codecs (mainly cause
           			 it will look ugly. So we should strip those but
           			 leave the rest. If we overrite it, oh well
			*/

        	$idx = 0;
        	foreach ($core_conf->_iax_general as $entry)
			{
          		switch (strtolower($entry['key']))
				{
            		case 'allow':
            		case 'disallow':
              			unset($core_conf->_iax_general[$idx]);
            		break;
          			default:
            			// do nothing
          		}
          		$idx++;
        	}

        	foreach ($raw_settings as $var)
			{
          		switch ($var['type'])
				{
            		case self::IAX_NORMAL:
              			$interim_settings[$var['keyword']] = $var['data'];
            			break;

            		case self::IAX_CODEC:
              			$codecs[$var['keyword']] = $var['data'];
            			break;

            		case self::IAX_VIDEO_CODEC:
              			$video_codecs[$var['keyword']] = $var['data'];
            			break;

            		case self::IAX_CUSTOM:
              			$iax_settings[] = array($var['keyword'], $var['data']);
            			break;

          			default:
            			// Error should be above
          		}
        	}
        	unset($raw_settings);

        	/* Codecs First */
        	$core_conf->addIaxGeneral('disallow','all');
        	asort($codecs);
        	foreach ($codecs as $codec => $enabled)
			{
          		if ($enabled != '')
				{
            		$core_conf->addIaxGeneral('allow', $codec);
          		}
        	}
        	unset($codecs);

        	if (isset($interim_settings['videosupport']) && $interim_settings['videosupport'] == 'yes')
			{
          		asort($video_codecs);
          		foreach ($video_codecs as $codec => $enabled)
				{
            		if ($enabled != '')
					{
              			$core_conf->addIaxGeneral('allow', $codec);
            		}
          		}
        	}
        	unset($video_codecs);

        	/* next figure out what we need to write out (deal with things like nat combos, etc. */

        	$jitterbuffer = isset($interim_settings['jitterbuffer']) && $interim_settings['jitterbuffer'] ? $interim_settings['jitterbuffer'] : '';
        	if (isset($interim_settings) && is_array($interim_settings))
			{
				foreach ($interim_settings as $key => $value)
				{
	          		switch ($key)
					{
	            		case 'videosupport':
	            			break;

	            		case 'maxjitterbuffer':
	            		case 'maxjitterinterps':
	            		case 'resyncthreshold':
	            		case 'forcejitterbuffer':
	              			if ($jitterbuffer == 'yes' && $value != '') 
							{
	                			$iax_settings[] = array($key, $value);
	              			}
	            			break;

	            		case 'bandwidth':
	              			if ($value != 'unset')
							{
	                			$iax_settings[] = array($key, $value);
	              			}
	            			break;

	            		default:
	              			$iax_settings[] = array($key, $value);
	            	}
	        	}
			}
        	unset($interim_settings);

          	if (isset($iax_settings) && is_array($iax_settings))
			{
				foreach ($iax_settings as $entry)
				{
            		if ($entry[1] != '')
					{
              			$core_conf->addIaxGeneral($entry[0], $entry[1]);
            		}
          		}
			}
      	}
  		return true;
	}
}
