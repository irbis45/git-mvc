<?php

/**
 * Class View
 */
class View
{
	/**
	 * @param $filename
	 */
    public function render($filename)
    {
        require 'app/view/' . $filename . '.php';
    }
	
	/**
	 *
	 */
    public function renderFeedback()
    {
        require 'app/view/_templates/feedback.php';

        Session::set('feedback_negative', null);
        Session::set('feedback_positive', null);
    }
}
