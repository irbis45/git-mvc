<?php

/**
 * Class Session
 */
class Session
{
	/**
	 *
	 */
    public static function init()
    {
        if (session_id() == '') {
            session_start();
        }
    }
	
	/**
	 *
	 */
    public static function destroy()
    {
        session_destroy();
    }
	
	/**
	 * @param $key
	 * @param $value
	 */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
	
	/**
	 * @param $key
	 *
	 * @return mixed
	 */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

}
