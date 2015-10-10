<?php include 'init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Front Page Example</title>

<?php include TEMPLATE_MIDDLE; ?>
	<div class="container col-xs-12">
		<h2>
			Welcome to Database Project
		</h2>
		<hr>
		<div class="row">
			<div class="col-xs-6">
				<h4>Log In</h4>
				<form role="form" action="" method="post">
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="pass" placeholder="Password">
					</div>
					<button type="submit" name="login" class="btn btn-default">Log In</button>
				</form>
			</div>
			<div class="col-xs-6">
				<h4>Create Account</h4>
				<form role="form" action="" method="post">
					<div class="form-group">
						<input class="form-control" name="fname" placeholder="First name">
					</div>
					<div class="form-group">
						<input class="form-control" name="lname" placeholder="Last name">
					</div>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="pass" placeholder="Password">
					</div>
					<button type="submit" name="createaccount" class="btn btn-default">Create Account</button>
				</form>
			</div>
		</div>
	</div>

<?php include TEMPLATE_BOTTOM; ?>