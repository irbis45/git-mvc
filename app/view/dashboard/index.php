<!DOCTYPE html>
<html>
<head>
	<title>Task view</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
	<link rel="stylesheet" type="text/css" href="/app/resources/css/jquery.datetimepicker.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="/app/resources/css/table-sort.css" type="text/css">
	<link rel="stylesheet" href="/app/resources/css/style.css" type="text/css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	
	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo URL; ?>">Home <span class="sr-only">(current)</span></a>
			</li>
			<?php if (isset($_SESSION['user_logged_in'])) { ?>
				<li class="nav-item">
					<a class="nav-link js-logout" href="#">Logout</a>
				</li>
			<?php } else { ?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo URL; ?>login">Auth</a>
				</li>
			<?php } ?>
		
		</ul>
	</div>
</nav>


<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col">
					<h3 class="title">Task list</h3>
				</div>
			</div>
			
			<div class="form-group">
				<button type="button" class="btn btn-primary js-show-modal-task" data-action="create"
					data-toggle="modal"
					data-target="#formTask">
					Add new task
				</button>
			</div>
			
			<div id="pager" class="pager">
				<form>
					<span class="ico first"></span>
					<span class="ico prev"></span>
					<input type="text" class="pagedisplay" title="pagedisplay" />
					<span class="ico next"></span>
					<span class="ico last"></span>
					
					<select class="pagesize">
						<option selected="selected" value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="10">10</option>
					</select>
				</form>
			</div>
			
			<div class="alert alert-info js-msg-main hide"></div>
			
			<table cellspacing='0' class="table tablesorter">
				<thead>
				<tr>
					<th scope="col">Image</th>
					<th scope="col">User</th>
					<th scope="col">Email</th>
					<th scope="col">Task Name</th>
					<th scope="col">Status</th>
					<th scope="col">Operations</th>
				</tr>
				</thead>
				<tbody>
				<?php
				
				$counter = 0;
				if ($this->tasks) {
					
					foreach ($this->tasks as $key => $value) {
						
						$task_deadline = new DateTime($value->task_deadline, new DateTimeZone('Europe/Zagreb'));
						$time_now      = new DateTime('NOW', new DateTimeZone('Europe/Zagreb'));
						$overdue_until = $time_now->diff($task_deadline);
						
						$priority = TaskOps::get_priority($value->task_priority);
						$status   = TaskOps::get_status($value->task_completed);
						
						if ($counter % 2 == 0) {
							echo '<tr class="even" data-id="' . $value->task_id . '">';
							echo '<td class="js-task-image task-image"><img src="' . $value->image . '" alt=""/></td>';
							echo '<td>' . $value->user_name . '</td><td>' . $value->user_email . '</td>';
							echo '<td class="js-task-name">' . $value->task_name . '</td>';
							echo '<td class="js-status">' . $status . '</td>';
							echo '<td><button type="button" class="js-show-modal-task custom-a-btn" data-action="update" data-toggle="modal" data-task-id="' . $value->task_id . '"
					data-target="#formTask">
							Edit</button><br/>';
							echo '<a href="" data-task-id="' . $value->task_id . '" class="js-task-delete">Delete</a><br/>';
							
							echo '<a href="" role="button" data-task-id="' . $value->task_id . '" class="js-task-complete">' . (! $value->task_completed ? "Complete" : "Uncomplete") . '</a></td>';
							echo '</tr>';
						} else {
							echo '<tr data-id="' . $value->task_id . '">';
							echo '<td class="js-task-image task-image"><img src="' . $value->image . '" alt="" /></td>';
							echo '<td>' . $value->user_name . '</td><td>' . $value->user_email . '</td>';
							echo '<td class="js-task-name">' . $value->task_name . '</td>';
							
							echo '<td class="js-status">' . $status . '</td>';
							echo '<td><button type="button" class="custom-a-btn js-show-modal-task js-edit-task" data-action="update" data-toggle="modal" data-task-id="' . $value->task_id . '"
					data-target="#formTask">
							Edit</button><br/>';
							echo '<a href="" data-task-id="' . $value->task_id . '" class="js-task-delete">Delete</a><br/>';
							echo '<a href="" data-task-id="' . $value->task_id . '" class="js-task-complete">' . (! $value->task_completed ? "Complete" : "Uncomplete") . '</a></td>';
							echo '</tr>';
							
						}
						$counter++;
					}
				} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal add task-->
<div class="modal fade" id="formTask" tabindex="-1" role="dialog" aria-labelledby="formTask"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			
			<div class="modal-header">
				<h5 class="modal-title">Task</h5>
			</div>
			
			<form class="form js-form-task" id="upload-image" enctype="multipart/form-data">
				
				<div class="alert alert-info js-msg"></div>
				
				<div class="modal-body">
					
					<div class="form-group">
						<label for="from-create-task__name">Enter task name:</label>
						<input id="from-create-task__name" class="form-control js-field-name" type="text"
							name="task_name" title="task-name"
							autofocus required>
					</div>
					
					<div class="form-group">
						<label for="from-create-task__dsc">Enter task dsc:</label>
						<input id="from-create-task__dsc" class="form-control js-field-dsc" type="text" name="task_dsc"
							title="task-dsc">
					</div>
					
					<div class="form-group">
						<select name="task_priority" title="task_priority" class="js-field-priority form-control"
							required>
							<option value="" selected="selected">Select priority:</option>
							<option value="1">Low</option>
							<option value="2">Normal</option>
							<option value="3">High</option>
						</select>
					</div>
					
					<div class="form-group">
						<label for="datetimepicker1">Pick task deadline:</label>
						<input id="datetimepicker1" class="form-control js-field-deadline" type="text"
							name="task_deadline"
							title="from-create-task__deadline" autocomplete="off">
					
					</div>
					
					<div class="form-group">
						<input type="file" name="image" id="image">
						
						<div class="image-preview">
							<img id="preview" class="preview-img" src="" alt="">
						</div>
					</div>
					
					<input type="hidden" name="type-query" value="" class="js-hidden-type">
					<input type="hidden" name="task_id" value="" class="js-hidden-task-id">
				</div>
				
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Ok" />
				</div>
			</form>
		
		</div>
	</div>
</div>

<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/app/resources/javascript/libs/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/app/resources/javascript/libs/jquery.tablesorter.js"></script>
<script type="text/javascript" src="/app/resources/javascript/libs/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="/app/resources/javascript/main.js"></script>
</body>
</html>
