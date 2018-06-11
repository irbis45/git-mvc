<?php

/**
 * Class LoginModel
 */
class LoginModel
{
	
	/**
	 * LoginModel constructor.
	 *
	 * @param $db
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}
	
	
	/**
	 * @return bool
	 */
	public function loginUser()
	{
		$validate = Validator::getInstance()->validateUserAuth($_POST);
		
		if ($validate) {
			$query = $this->db->prepare("SELECT user_id,
    									  user_name,
    									  user_password_hash,
    									  user_email,
                                          user_active
									FROM  user
									WHERE user_name = :user_name");
			
			$query->execute(array(':user_name' => $_POST['user_login']));
			
			$count = $query->rowCount();
			
			if ($count !== 1) {
				$_SESSION['feedback_negative'][] = "Login failed! User with that email does not exist!";
				
				return false;
			}
			
			$result = $query->fetch();
			
			if (password_verify($_POST['user_password'], $result->user_password_hash)) {
				
				if ($result->user_active != 1) {
					$_SESSION['feedback_negative'][] = "Your account is not activated! Please activate your account!";
					
					return false;
				}
				
				Session::init();
				Session::set('user_logged_in', true);
				Session::set('user_id', $result->user_id);
				Session::set('user_name', $result->user_name);
				
				$user_last_login_timestamp = time();
				
				$query = $this->db->prepare("UPDATE user SET user_last_login_timestamp = :user_last_login_timestamp WHERE user_id = :user_id");
				$query->execute(array(
					':user_id'                   => $result->user_id,
					':user_last_login_timestamp' => $user_last_login_timestamp
				));
				
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 *
	 */
	public function logout()
	{
		Session::destroy();
	}
	
}
