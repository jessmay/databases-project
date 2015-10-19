<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Event View Page</title>

<?php include TEMPLATE_MIDDLE;
	// TODO verify user has permission to view this event
	// have university id passed into page
	// RSO association with RSO event
	// Add event to user events if button is clicked
	// Verify user has no conflicts when signing up for event
	// comments - view done, need to be able to add
	// ratings
	// facebook sharing
 
	$event_id = 2;

	$event_query = '
		SELECT *
		FROM Event E
		WHERE E.Event_id = :id
	';

	$event_params = array(':id' => $event_id);
	$result = $db->prepare($event_query);
	$result->execute($event_params);
	$row = $result->fetch();
	
	$event_name = $row['Name'];
	$event_date_time = $row['Date_time'];
	
	$location_query = '
		SELECT L.Name
		FROM location L, event_location EL
		WHERE EL.Event_id = :id AND EL.Location_id = L.Location_id
	';
	$location_result = $db->prepare($location_query);
	$location_result->execute($event_params);
	$location_row = $location_result->fetch();
	$event_location = $location_row['Name'];

	echo "<h2>$event_name</h2>
	<h4>$event_date_time, $event_location</h4>
	<hr>";
	
	$cat_id = $row['Category_id'];
	$category_query = '
		SELECT C.Name
		FROM category C
		WHERE C.Category_id = :cat_id
	';
	$category_params = array(':cat_id' => $cat_id);
	$category_result = $db->prepare($category_query);
	$category_result->execute($category_params);
	$category_row = $category_result->fetch();
	$event_category = $category_row['Name'];
	
	echo "<h4>Category</h4>
	<p>$event_category</p>
	<br>";
	
	$event_description = $row['Description'];
	echo "<h4>Event Description</h4>
	<p>$event_description</p>
	<br>";
	
	$event_phone = $row['Contact_phone'];
	$event_email = $row['Contact_email'];
	echo "<h4>Contact Information</h4>
	<p>Phone:	$event_phone</p>
	<p>Email:	$event_email</p>
	<br>";
	
	
	$comment_query = '
		SELECT *
		FROM comment C
		WHERE C.Event_id = :id
	';
	
	$comment_result = $db->prepare($comment_query);
	$comment_result->execute($event_params);
	
	echo "<h4>Comments:</h4>";
	
	while($comment_rows = $comment_result->fetch()) {
		$user_id = $comment_rows['User_id'];
		
		$user_query = '
			SELECT U.First_name, U.Last_name
			FROM user U
			WHERE U.User_id = :user_id
		';
		
		$user_params = array(':user_id' => $user_id);
		$user_result = $db->prepare($user_query);
		$user_result->execute($user_params);
		$user_row = $user_result->fetch();
		
		$user_first_name = $user_row['First_name'];
		$user_last_name = $user_row['Last_name'];
		
		$comment = $comment_rows['Message'];
		$time = $comment_rows['Date'];
		echo "<h5><strong>$user_first_name $user_last_name:</strong>$comment</h5><h6>$time</h6><hr>";
	}
	
?>

<p>
	<form>
		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<label class="control-label" for="eventComment">Add a Comment</label>
					<input type="text" class="form-control" id="eventComment" name="eventComment" placeholder="ex: Type your comment here." size="160" maxlength="160" required>
				</div>
			</div>
			<div class="col-md-1">
				<button type="submit" class="btn btn-primary">Post Comment</button>
			</div>
		</div>
	</form>
</p>
	
<button type="submit" class="btn btn-primary">Join Event</button>
	
<?php include TEMPLATE_BOTTOM; ?>