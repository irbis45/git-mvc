<?php

/**
 * Class Login
 */
class Login extends Controller
{
	/**
	 * Login constructor.
	 */
    public function __construct()
    {
        parent::__construct();
        if (isset($_SESSION['user_logged_in'])) {
            header('location:' . URL . 'dashboard');
        }
    }
	
	/**
	 *
	 */
    public function index()
    {
        $this->view->render('login/login');
    }
	
	/**
	 *
	 */
    public function login_submit()
    {

        $login_model      = $this->loadModel('LoginModel');
        $login_successful = $login_model->loginUser();

        if ($login_successful) {
            header('location:' . URL . 'dashboard');
        } else {
            header('location:' . URL . 'login');
        }
    }
	
	/**
	 *
	 */
    public function logout()
    {
        $login_model = $this->loadModel('LoginModel');
        $login_model->logout();

        header('location:' . URL . 'login');
    }

}
