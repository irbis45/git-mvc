<?php

/**
 * Class TaskOps
 */
class TaskOps
{
	
	/**
	 * @param $priority
	 *
	 * @return string
	 */
    public static function get_priority($priority)
    {

        switch ($priority) {
            case '1':
                $priority = 'Low';
                break;
            case '2':
                $priority = 'Normal';
                break;
            case '3':
                $priority = 'High';
                break;
            default:
                $priority = 'Low';
        }
        return $priority;
    }
	
	/**
	 * @param $status
	 *
	 * @return string
	 */
    public static function get_status($status)
    {

        switch ($status) {
            case '0':
                $status = 'Not Completed';
                break;
            case '1':
                $status = 'Completed';
                break;
            default:
                $status = 'Not completed';
        }
        return $status;
    }
}
