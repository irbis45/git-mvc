<?php

/**
 * Class Register
 */
class Register extends Controller
{
	/**
	 * Register constructor.
	 */
    public function __construct()
    {
        parent::__construct();

    }
	
	/**
	 *
	 */
    public function index()
    {
        $this->view->render('register/register');
    }
	
	/**
	 *
	 */
    public function register_submit()
    {
        $register_model          = $this->loadModel('RegisterModel');
        $registration_successful = $register_model->registerNewUser();

        header('location: ' . URL . 'register');
    }

}
