<?php

/**
 * Class Dashboard
 */
class Dashboard extends Controller
{
	/**
	 * @return bool
	 */
	protected function checkUserPermission()
	{
		if (isset($_SESSION['user_id'])) {
			$sql   = "SELECT is_admin
                    FROM user
                    WHERE user_id = :user_id ";
			$query = $this->db->prepare($sql);
			$query->execute(array(':user_id' => $_SESSION['user_id']));
			$count = $query->rowCount();
			
			if (0 != $count && $query->fetch()->is_admin) {
				return true;
			}
		}
		
		header('Content-Type: application/json');
		echo json_encode(array('err' => 'Permission denied'));
		
		die();
	}
	
	/**
	 * Dashboard constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		//if need login
		//Auth::handleLogin();
	}
	
	/**
	 *
	 */
	public function index()
	{
		$task_model        = $this->loadModel('TaskModel');
		$tasks             = $task_model->showTasks();
		$this->view->tasks = $tasks;
		
		$this->view->render('dashboard/index');
	}
	
	/**
	 * @return bool
	 */
	public function mark_completed()
	{
		$this->checkUserPermission();
		
		if ( ! Validator::getInstance()->validate($_POST)) {
			return false;
		}
		
		$task_id = $_POST['task_id'];
		
		if (isset($task_id)) {
			
			$task_model = $this->loadModel('TaskModel');
			$res        = $task_model->markTaskComplete($task_id);
			
			header('Content-Type: application/json');
			echo json_encode(array('msg' => $res, "refresh" => true));
		}
		
		die();
	}
	
	/**
	 * @return bool
	 */
	public function delete_task()
	{
		$this->checkUserPermission();
		
		if ( ! Validator::getInstance()->validate($_POST)) {
			return false;
		}
		
		$task_model = $this->loadModel('TaskModel');
		$status     = $task_model->deleteTask($_POST['task_id']);
		
		header('Content-Type: application/json');
		echo json_encode(array('msg' => $status, "refresh" => true));
		
		die();
	}
	
	/**
	 * @return bool
	 */
	public function add_new_task()
	{
		if ( ! Validator::getInstance()->validate($_POST, 'create')) {
			return false;
		}
		
		$task_model = $this->loadModel('TaskModel');
		$status     = $task_model->addNewTask($_POST, $_FILES);
		
		$task_data = [];
		if (is_int($status)) {
			$task_data = $task_model->getTaskData($status);
			$status    = 'Task added!';
		}
		
		header('Content-Type: application/json');
		echo json_encode(array('msg' => $status, 'task' => $task_data));
		
		die();
	}
	
	/**
	 * @return bool
	 */
	public function edit_task()
	{
		$this->checkUserPermission();
		
		if ( ! Validator::getInstance()->validate($_POST, 'update')) {
			return false;
		}
		
		$task_model = $this->loadModel('TaskModel');
		$status     = $task_model->updateTask($_POST, $_FILES);
		
		$task_data = $task_model->getTaskData($_POST['task_id']);
		
		
		header('Content-Type: application/json');
		echo json_encode(array('msg' => $status, 'task' => $task_data));
		
		return false;
	}
	
	/**
	 * @return bool
	 */
	public function get_task()
	{
		$task_model = $this->loadModel('TaskModel');
		$task       = $task_model->getTaskData($_POST['task_id']);
		
		header('Content-Type: application/json');
		echo json_encode(array('data' => $task));
		
		return false;
	}
}
