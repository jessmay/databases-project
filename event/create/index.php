<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Create Event</title>
	<script>
		$(function() {
			$( "#datepicker" ).datepicker();
            $.widget("ui.hourspin", $.ui.spinner, {
                _parse: function(value) {
                    if (typeof value === "string") {
                        var pm = value.split(' ')[1] == "PM";
                        var hour = parseInt(value);
                        if (hour == 12) {
                            return pm * 12;
                        }
                        return hour + (pm ? 12 : 0);
                    } else {
                        return value;
                    }
                },
                _format: function(value) {
                    if (value < 12) {
                        if (value == 0) {
                            return "12 AM";
                        }
                        return value + " AM";
                    } else {
                        if (value == 12) {
                            return "12 PM";
                        }
                        return (value - 12) + " PM";
                    }
                }
            });
            $( "#timespinner" ).hourspin({
                spin: function(event, ui) {
                    if (ui.value > 23) {
                        $(this).hourspin("value", 0);
                        return false;
                    }
                    else if (ui.value < 0) {
                        $(this).hourspin("value", 23);
                        return false;
                    }
                }
            });
		});
	</script>

<?php include TEMPLATE_MIDDLE; ?>
    <h2>
        Create Event
    </h2>
    <hr>
	<p>
		<form>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="eventName">Name</label>
						<input type="text" class="form-control" id="eventName" name="eventName" placeholder="ex: Career Expo" size="50" maxlength="50" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="eventCategory">Category</label>
						<select class="form-control">
							<option>Social</option>
							<option>Fundraiser</option>
							<option>Tech Talk</option>
                            <option>Academic</option>
                            <option>Concert</option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="eventDescription">Description</label>
				<textarea class="form-control" id="eventDescription" rows="3" placeholder="Add more info" size="160" maxlength="160" required></textarea>
			</div>
			
			<div class="form-group">
				<label for="eventLocation">Where</label>
				<input type="text" class="form-control" id="eventLocation" placeholder="ex: Room 101 of Engineering Building" size="50" maxlength="50" required>
			</div>
			
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="eventDate">Date</label>
					<input type="text" class="form-control" id="datepicker" pattern="[0-1][0-9]/[0-3][1-9]/20[0-9][0-9]" required>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-4 form-group">
					<label for="eventTime">Time</label>
					<input type="text" id="timespinner" name="timespinner" value="12 PM" pattern="(1|2|3|4|5|6|7|8|9|10|11|12) (PM|AM)" required>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-1">
					<b>Type</b>
				</div>
				<div class="col-md-2">			
					<input type="radio" name="eventTypes" id="eventTypes1" value="type1" checked="checked"> Public
				</div>
				<div class="col-md-2">
					<input type="radio" name="eventTypes" id="eventTypes2" value="type2"> Private
				</div>
				<div class="col-md-2">
					<input type="radio" name="eventTypes" id="eventTypes3" value="type3"> RSO
				</div>
                <div class="col-md-3">
                    If not RSO, approved?
                </div>
                <div class="col-md-1">			
					<input type="radio" name="eventApprove" id="eventApprove1" value="yes"> Yes
				</div>
				<div class="col-md-1">
					<input type="radio" name="eventApprove" id="eventApprove2" value="no" checked="checked"> No
				</div>
			</div><br>
						
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="eventContactName">Contact Name</label>
					<input type="text" class="form-control" id="eventContactName" placeholder="Name" pattern="[A-Za-z]+" size="50" maxlength="50" required>
				</div>
				<div class="col-md-4 form-group">
					<label for="eventContactEmail">Contact Email</label>
					<input type="email" class="form-control" id="eventContactEmail" placeholder="ex: rso@university.edu" size="50" maxlength="50" required>
				</div>
				<div class="col-md-4 form-group">
					<label for="eventContactPhone">Contact Phone</label>
					<input type="tel" class="form-control" id="eventContactPhone" placeholder="ex: 1234567890" pattern="[0-9]{10,11}" size="11" maxlength="11" required>
				</div>
			</div><br>
			
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</p>

<?php include TEMPLATE_BOTTOM; ?>