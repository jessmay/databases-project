<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Create University</title>

<?php include TEMPLATE_MIDDLE; ?>
    <h2>
        Create University
    </h2>
    <hr>
	<p>
		<form>
        	<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="univName">Name</label>
                        <input type="text" class="form-control" id="univName" name="univName" placeholder="ex: University of Central Florida (UCF)" pattern="[A-Za-z]+" size="50" maxlength="50" required>
                    </div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="univStudentCount">Number of Students</label>
						<input type="number" class="form-control" id="univStudentCount" name="univStudentCount" placeholder="ex: 60576" min="0" max="10000000" required>
					</div>
				</div>
			</div>
			
            <div class="form-group">
				<label for="univDescription">Description</label>
				<textarea class="form-control" id="univDescription" rows="3" placeholder="Add more info" size="160" maxlength="160" required></textarea>
			</div>
            
            <div class="form-group">
				<label for="univLocation">Location</label>
				<input type="text" class="form-control" id="univLocation" placeholder="ex: Orlando, Florida" size="50" maxlength="50" required>
			</div>
            
            <div class="form-group">
				<label for="univPicture">Picture</label>
				<input type="url" class="form-control" id="univPicture" placeholder="ex: https://pbs.twimg.com/profile_images/462235833274073088/2Mo_aqES.png" size="200" maxlength="200" required>
			</div><br>
            
			<button type="submit" class="btn btn-primary">Submit</button>
	</p>

<?php include TEMPLATE_BOTTOM; ?>