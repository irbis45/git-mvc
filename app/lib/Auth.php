<?php

/**
 * Class Auth
 */
class Auth
{
	/**
	 *
	 */
	public static function handleLogin()
	{
		Session::init();
		
		if ( ! isset($_SESSION['user_logged_in'])) {
			
			Session::destroy();
			header('location:' . URL . 'login');
			
			exit();
		}
	}
	
	/**
	 * @return int
	 */
	public static function getCurrentUserId()
	{
		if (isset($_SESSION['user_id'])) {
			return $_SESSION['user_id'];
		}
		
		return 2;//return profile guest
	}
}
