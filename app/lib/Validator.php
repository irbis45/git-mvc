<?php

/**
 * Class Validator
 */
class Validator
{
	
	private static $instance = null;
	
	/**
	 * @return Validator
	 */
	public static function getInstance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	private function __clone()
	{
	}
	
	private function __construct()
	{
	}
	
	
	/**
	 * @param $data
	 *
	 * @return string
	 */
	protected function validatorHelperForm($data)
	{
		$msg = '';
		
		if ( ! isset($data['task_name']) || ! $data['task_name']) {
			$msg .= 'Task name need fill!';
		}
		
		if ( ! isset($data['task_priority']) || ! $data['task_priority']) {
			$msg .= 'Priority need fill!';
		}
		
		return $msg;
	}
	
	/**
	 * @param $data
	 *
	 * @return string
	 */
	protected function validatorHelperTaskId($data)
	{
		if ( ! isset($data['task_id']) || ! $data['task_id']) {
			return 'Params task id not found!';
		}
		
		return '';
	}
	
	/**
	 * @param        $data
	 * @param string $type
	 *
	 * @return bool
	 */
	public function validate($data, string $type = '')
	{
		$msg = '';
		switch ($type) {
			case 'create':
				{
					$msg .= self::validatorHelperForm($data);
					
					break;
				}
			case 'update':
				{
					$msg .= self::validatorHelperTaskId($data);
					$msg .= self::validatorHelperForm($data);
					
					break;
				}
			default:
				{
					$msg .= self::validatorHelperTaskId($data);
					break;
				}
		}
		
		if ($msg) {
			header('Content-Type: application/json');
			echo json_encode(array('err' => $msg));
			
			die;
		}
		
		return true;
	}
	
	
	/**
	 * @return bool
	 */
	public function validateUserReg($data)
	{
		
		if (empty($data['user_name'])) {
			$_SESSION['feedback_negative'][] = "Name field is empty or doesn't fit pattern";
			
			return false;
		}
		
		if (empty($data['user_email'])) {
			$_SESSION['feedback_negative'][] = "Email field is empty or doesn't fit pattern";
			
			return false;
		}
		
		if (empty($data['user_lastname'])) {
			$_SESSION['feedback_negative'][] = "Lastname field is empty or doesn't fit pattern";
			
			return false;
		}
		
		if (empty($data['user_password'])) {
			$_SESSION['feedback_negative'][] = "Password field is empty";
			
			return false;
		}
		
		if (empty($data['user_email'])) {
			$_SESSION['feedback_negative'][] = "Email field is empty!";
			
			return false;
		}
		
		if ( ! filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['feedback_negative'][] = "Entered email doesn't fit email pattern";
			
			return false;
		}
		
		if (mb_strlen($data['user_name']) < 3 || !preg_match('/^[a-z\d]{2,30}$/i', $data['user_name'])) {
			$_SESSION['feedback_negative'][] = "Name more 3 or include incorrect char";
			
			return false;
		}
		
		if (mb_strlen($data['user_lastname']) < 3 || !preg_match('/^[a-z\d]{2,60}$/i', $data['user_lastname'])) {
			$_SESSION['feedback_negative'][] = "LastName more 3 or include incorrect char";
			
			return false;
		}
		
		if ( !filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['feedback_negative'][] = "Email incorrect";
			
			return false;
		}
		
		return true;
	}
	
	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public function validateUserAuth($data)
	{
		if ( ! isset($data['user_login']) || empty($data['user_login'])) {
			$_SESSION['feedback_negative'][] = "Username field is empty!";
			
			return false;
		}
		if ( ! isset($data['user_password']) || empty($data['user_password'])) {
			$_SESSION['feedback_negative'][] = "Password field is empty!";
			
			return false;
		}
		
		return true;
	}
}