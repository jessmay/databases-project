<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Front Page Example</title>
	<script>
		$(function() {
			$( "#datepicker" ).datepicker();
		});
	</script>

<?php include TEMPLATE_MIDDLE; ?>
	<p>
		<form>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="eventName">Name</label>
						<input type="text" class="form-control" id="eventName" placeholder="ex: Career Expo">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="eventCategory">Category</label>
						<select class="form-control">
							<option>Select one</option>
							<option>Social</option>
							<option>Fundraiser</option>
							<option>Social</option>
							<option>Tech Talk</option>
							<option>Other</option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="eventDescription">Description</label>
				<textarea class="form-control" id="eventDescription" rows="3" placeholder="Add more info"></textarea>
			</div>
			
			<div class="form-group">
				<label for="eventLocation">Where</label>
				<input type="text" class="form-control" id="eventName" placeholder="ex: Room 101 of Engineering Building">
			</div>
			
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="eventDate">Date</label>
					<input type="text" class="form-control" id="datepicker">
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-4 form-group">
					<label for="eventTime">Time</label>
					<!-- TODO: Change to spinner of hours -->
					<input type="text" class="form-control" id="eventTime" placeholder="ex: 03:00 PM">
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-1">
					<b>Type</b>
				</div>
				<div class="col-md-2">			
					<input type="radio" name="eventTypes" id="eventTypes1" value="type1"> Public
				</div>
				<div class="col-md-2">
					<input type="radio" name="eventTypes" id="eventTypes2" value="type2"> Private
				</div>
				<div class="col-md-2">
					<input type="radio" name="eventTypes" id="eventTypes3" value="type3"> RSO
				</div>
			</div><br />
						
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="eventContactName">Contact Name</label>
					<input type="email" class="form-control" id="eventContactName" placeholder="Name">
				</div>
				<div class="col-md-4 form-group">
					<label for="eventContactEmail">Contact Email</label>
					<input type="email" class="form-control" id="eventContactEmail" placeholder="ex: rso@university.edu">
				</div>
				<div class="col-md-4 form-group">
					<label for="eventContactPhone">Contact Phone</label>
					<input type="email" class="form-control" id="eventContactPhone" placeholder="ex: (123) 456-7890">
				</div>
			</div><br />
			
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</p>

<?php include TEMPLATE_BOTTOM; ?>