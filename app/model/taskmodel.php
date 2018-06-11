<?php

/**
 * Class TaskModel
 */
class TaskModel
{
	/**
	 * @var int
	 */
	protected $task_id = 0;
	
	/**
	 * @var string
	 */
	protected $task_name = '';
	
	/**
	 * @var string
	 */
	protected $task_deadline = '';
	
	/**
	 * @var string
	 */
	protected $task_priority = '';
	
	/**
	 * @var string
	 */
	protected $task_description = '';
	
	/**
	 * @var string
	 */
	protected $task_img = '';
	
	/**
	 * @param $data
	 */
	protected function fillParams($data)
	{
		$this->task_id          = isset($data['task_id']) ? strip_tags($data['task_id']) : 0;
		$this->task_deadline    = isset($data['task_deadline']) ? strip_tags($data['task_deadline']) : '';
		$this->task_description = isset($data['task_dsc']) ? strip_tags($data['task_dsc']) : '';
		$this->task_name        = isset($data['task_name']) ? strip_tags($data['task_name']) : '';
		$this->task_priority    = isset($data['task_priority']) ? strip_tags($data['task_priority']) : '';
	}
	
	/**
	 * @param $file
	 *
	 * @return bool
	 */
	protected function imgUpload($file)
	{
		
		if (isset($file['image'])) {
			$uploadClass    = new FileUpload($file['image']);
			$this->task_img = $uploadClass->upload_file();
		}
		
		return false;
	}
	
	/**
	 * TaskModel constructor.
	 *
	 * @param $db
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}
	
	/**
	 * @param $task_id
	 *
	 * @return bool
	 */
	private function getTaskStatus($task_id)
	{
		if (isset($task_id)) {
			
			$sql   = "SELECT task_completed FROM task WHERE task_id = $task_id";
			$query = $this->db->prepare($sql);
			$query->execute();
			
			if ($query->rowCount() == 1) {
				
				$data = $query->fetch();
				
				if ($data->task_completed === 1) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * @return mixed
	 */
	public function showTasks()
	{
		$sql = "SELECT t.task_name, t.task_id, t.task_priority, t.task_deadline, t.task_completed, user_t.user_id, user_t.user_name, user_t.user_email, t.image
                FROM task AS t
                LEFT JOIN user AS user_t ON user_t.user_id = t.user_id";
		
		$query = $this->db->prepare($sql);
		$query->execute();
		
		return $query->fetchAll();
	}
	
	/**
	 * @param $data
	 * @param $file
	 *
	 * @return int|string
	 */
	public function addNewTask($data, $file)
	{
		$user_id = Auth::getCurrentUserId();
		$this->imgUpload($file);
		$this->fillParams($data);
		
		$sql = "INSERT INTO task (task_name, task_deadline, task_priority, user_id, image, description)
                    VALUES (:task_name, :task_deadline, :task_priority, :user_id, :image, :description)";
		
		$query = $this->db->prepare($sql);
		$query->execute(array(
			':task_name'     => $this->task_name,
			':task_deadline' => $this->task_deadline,
			':task_priority' => $this->task_priority,
			':user_id'       => $user_id,
			':image'         => $this->task_img,
			':description'   => $this->task_description,
		));
		
		if ($query->rowCount() == 1) {
			return (int)$this->db->lastInsertId();
		} else {
			return "Adding new task operation failed!";
		}
	}
	
	/**
	 * @param $task_id
	 *
	 * @return bool
	 */
	public function getTaskData($task_id)
	{
		if (isset($task_id)) {
			
			$sql = "SELECT t.task_name, t.task_id, t.task_priority, t.task_deadline, t.task_completed, user_t.user_id, user_t.user_name, user_t.user_email, t.image
                FROM task AS t
                LEFT JOIN user AS user_t ON user_t.user_id = t.user_id
                WHERE t.task_id = :task_id";
			
			$query = $this->db->prepare($sql);
			$query->execute(array(':task_id' => $task_id));
			
			if ($query->rowCount() === 1) {
				return $query->fetch();
			} else {
				return false;
			}
		}
		
		return false;
	}
	
	/**
	 * @param $data
	 * @param $file
	 *
	 * @return bool|string
	 */
	public function updateTask($data, $file)
	{
		$this->imgUpload($file);
		$this->fillParams($data);
		
		if ($this->task_img) {
			$sql   = "UPDATE task
                        SET task_name = :task_name, task_deadline = :task_deadline, task_priority = :task_priority, image = :image, description = :description
                        WHERE task_id = :task_id";
			$query = $this->db->prepare($sql);
			$query->execute(array(
				':task_name'     => $this->task_name,
				':task_deadline' => $this->task_deadline,
				':task_priority' => $this->task_priority,
				':image'         => $this->task_img,
				':description'   => $this->task_description,
				':task_id'       => $this->task_id
			));
			
		} else {
			$sql = "UPDATE task
                        SET task_name = :task_name, task_deadline = :task_deadline, task_priority = :task_priority, description = :description
                        WHERE task_id = :task_id";
			
			$query = $this->db->prepare($sql);
			$query->execute(array(
				':task_name'     => $this->task_name,
				':task_deadline' => $this->task_deadline,
				':task_priority' => $this->task_priority,
				':description'   => $this->task_description,
				':task_id'       => $this->task_id
			));
		}
		
		
		if ($query->rowCount() === 1) {
			return "Task updated";
		} else {
			return "Task update operation failed!";
		}
		
		
		return false;
		
	}
	
	/**
	 * @param $task_id
	 *
	 * @return bool|string
	 */
	public function deleteTask($task_id)
	{
		if (isset($task_id)) {
			$sql   = "DELETE FROM task WHERE task_id = :task_id";
			$query = $this->db->prepare($sql);
			$query->execute(array(':task_id' => $task_id));
			
			$count = $query->rowCount();
			
			if ($count === 1) {
				return "Task deleted";
				
			} else {
				return "Task delete operation failed!";
			}
		}
		
		return false;
		
	}
	
	/**
	 * @param $task_id
	 *
	 * @return bool|string
	 */
	public function markTaskComplete($task_id)
	{
		if (isset($task_id)) {
			
			$current_status = $this->getTaskStatus($task_id);
			
			$status = $current_status ? 0 : 1;
			
			$sql   = "UPDATE task SET task_completed = :status WHERE task_id = $task_id";
			$query = $this->db->prepare($sql);
			$query->execute(array(':status' => $status));
			
			$count = $query->rowCount();
			
			if ($count === 1 && $status) {
				return "Complete";
			} else if ($count === 1 && ! $status) {
				return "Not Complete";
			} else {
				return "Task already marked complete!";
			}
		}
		
		return false;
		
	}
}
