<?php

class iaxsettings_validate
{
    protected $errors = array();

    /* checks if value is an integer */
    function is_int($value, $item, $message, $negative=false)
    {
        $value = trim($value);
        if ($value != '' && $negative)
        {
            $tmp_value = substr($value,0,1) == '-' ? substr($value,1) : $value;
            if (!ctype_digit($tmp_value))
            {
                $this->errors[] = array('id' => $item, 'value' => $value, 'message' => $message);
            }
        }
        elseif (!$negative)
        {
            if (!ctype_digit($value) || ($value < 0 ))
            {
                $this->errors[] = array('id' => $item, 'value' => $value, 'message' => $message);
            }
        }
        return $value;
    }

    /* checks if value is valid port between 1024 - 6 65535 */
    function is_ip_port($value, $item, $message)
    {
        $value = trim($value);
        if ($value != '' && (!ctype_digit($value) || $value < 1024 || $value > 65535))
        {
            $this->errors[] = array('id' => $item, 'value' => $value, 'message' => $message);
        }
        return $value;
    }

    /* checks if value is valid ip format */
    function is_ip($value, $item, $message)
    {
        $value = trim($value);

        if (!filter_var($value, FILTER_VALIDATE_IP))
        {
            $this->errors[] = array('id' => $item, 'value' => $value, 'message' => $message);
        }
        return $value;
    }

    /* checks if value is valid ip netmask format */
    function is_netmask($value, $item, $message)
    {
        $value = trim($value);
        if ($value != '' && !(preg_match('|^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$|',$value,$matches) || (ctype_digit($value) && $value >= 0 && $value <= 24))) {
            $this->errors[] = array('id' => $item, 'value' => $value, 'message' => $message);
        }
        return $value;
    }

    /* checks if value is valid alpha numeric format */
    function is_alphanumeric($value, $item, $message)
    {
        $value = trim($value);
	    if ($value != '' && !preg_match("/^\s*([a-zA-Z0-9.&\-@_!<>!\"\']+)\s*$/",$value,$matches)) 
        {
            $this->errors[] = array('id' => $item, 'value' => $value, 'message' => $message);
        }
        return $value;
    }

    /* trigger a validation error to be appended to this class */
    function log_error($value, $item, $message)
    {
        $this->errors[] = array('id' => $item, 'value' => $value, 'message' => $message);
        return $value;
    }
}