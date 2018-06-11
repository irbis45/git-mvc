<!DOCTYPE html>
<html>
<head>
	<title>Todoer-login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
	<meta charset="UTF-8">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	
	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo URL; ?>">Home <span class="sr-only">(current)</span></a>
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
				<h2 class="title">Auth</h2>
				
				<form action="<?php echo URL; ?>login/login_submit" method="post" class="form">
					
					<div class="form-group has-error">
						<?php
						$this->renderFeedback();
						?>
					</div>
					
					<div class="form-group">
						<input type="text" class="form-control" name="user_login"
							placeholder="Please enter your login" required>
					</div>
					
					<div class="form-group">
						<input type="password" class="form-control" name="user_password" id="password"
							placeholder="Please enter your password"
							required>
					</div>
					
					<button type="submit" name="login" class="btn btn-primary">Log in</button>
				</form>
			</div>
		</div>
	
	</div>

</section>
</body>
</html>