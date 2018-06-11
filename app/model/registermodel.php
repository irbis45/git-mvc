<?php

/**
 * Class RegisterModel
 */
class RegisterModel
{
	
	/**
	 * RegisterModel constructor.
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
	public function registerNewUser()
	{
		$validate = Validator::getInstance()->validateUserReg($_POST);
		
		if ($validate) {
			
			$user_name          = strip_tags($_POST['user_name']);
			$user_lastname      = strip_tags($_POST['user_lastname']);
			$user_email         = strip_tags($_POST['user_email']);
			$user_password_hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
			
			$query = $this->db->prepare("SELECT user_id FROM user WHERE user_email = :user_email OR user_name = :user_name");
			$query->execute(array(':user_email' => $user_email, ':user_name' => $user_name));
			$count = $query->rowCount();
			
			if (1 === $count) {
				$_SESSION['feedback_negative'][] = "E-mail or username is already in use";
				
				return false;
			}
			
			$user_creation_time   = date("Y-m-d H:i:s");
			$user_activation_hash = sha1(uniqid(mt_rand(), true));
			
			$sql = "INSERT INTO user (user_name, user_lastname, user_password_hash, user_email, user_creation_time, user_activation_hash, user_active)
	                    VALUES (:user_name, :user_lastname, :user_password_hash, :user_email, :user_creation_time, :user_activation_hash, :user_active)";
			
			$query = $this->db->prepare($sql);
			$query->execute(array(
				':user_name'            => $user_name,
				':user_lastname'        => $user_lastname,
				':user_password_hash'   => $user_password_hash,
				':user_email'           => $user_email,
				':user_creation_time'   => $user_creation_time,
				':user_activation_hash' => $user_activation_hash,
				':user_active'          => 1
			));
			
			$count = $query->rowCount();
			if (1 !== $count) {
				$_SESSION['feedback_negative'][] = "Registration failed!";
				
				return false;
			}
			
			$query = $this->db->prepare("SELECT user_id FROM user WHERE user_email = :user_email");
			$query->execute(array(':user_email' => $user_email));
			
			if (1 !== $query->rowCount()) {
				$_SESSION['feedback_negative'][] = "Internal error! New user registartion failed!";
				
				return false;
			}
			
			header('location:' . URL . 'login', true);
			exit;
		}
		
		
		return false;
	}
	
}
