<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	
	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo URL; ?>">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo URL; ?>login">Auth</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo URL; ?>register">Registration</a>
			</li>
		
		</ul>
	</div>
</nav>

<section id="main">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<h2 class="title">Register</h2>
				<form action="<?php echo URL; ?>register/register_submit" method="POST" class="form">
					
					<div class="form-group has-error">
						<?php
						$this->renderFeedback();
						?>
					</div>
					
					<div class="form-group">
						<input type="text" name="user_name" class="form-control"
							placeholder="Please enter your name (2 < chars < 30, letters only)" required>
					</div>
					<div class="form-group">
						<input type="text" name="user_lastname" class="form-control"
							placeholder="Please enter your lastname (2 < chars < 60, letters only):" required>
					</div>
					<div class="form-group">
						<input type="email" name="user_email" class="form-control"
							placeholder="Please enter your e-mail:"
							required />
					</div>
					<div class="form-group">
						<input class="form-control" type="password" name="user_password" pattern=".{3,}"
							placeholder="Please enter your password (min. 3 chars):" required autocomplete="off" />
					</div>
					
					<button type="submit" name="registration" class="btn btn-primary">Registration</button>
				</form>
			</div>
		</div>
	</div>
</section>
</body>
</html>
