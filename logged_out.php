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
				<button type="submit" name="login" class="btn btn-primary">Log In</button>
			</form>
		</div>
		<?php
			$fname = $email_taken ? $_POST['fname'] : '';
			$lname = $email_taken ? $_POST['lname'] : '';
			$email = $email_taken ? $_POST['email'] : '';
		?>
		<div class="col-xs-6">
			<h4>Create Account</h4>
			<form role="form" action="" method="post">
				<div class="form-group">
					<input class="form-control" name="fname" placeholder="First name" value="<?=$fname?>">
				</div>
				<div class="form-group">
					<input class="form-control" name="lname" placeholder="Last name" value="<?=$lname?>">
				</div>
				<?php if ($email_taken): ?>
				<div class="form-group has-error">
					<input type="email" class="form-control" name="email" placeholder="Email" value="<?=$email?>">
					<span id="invalidEmail" class="help-block">This email has already been used.</span>
				</div>
				<?php else: ?>
				<div class="form-group">
					<input type="email" class="form-control" name="email" placeholder="Email" value="<?=$email?>">
				</div>
				<?php endif; ?>
				<div class="form-group">
					<input type="password" class="form-control" name="pass" placeholder="Password">
				</div>
				<button type="submit" name="createaccount" class="btn btn-success">Create Account</button>
			</form>
		</div>
	</div>
</div>