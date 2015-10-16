<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Event View Page</title>

<?php include TEMPLATE_MIDDLE; 
	$event_id = 2;

	$event_name_query = '
		SELECT *
		FROM Event E
		WHERE E.Event_id = :id
	';
	// Standardize email
	$email = strtolower($email);

	$event_params = array(':id' => $event_id);
	$result = $db->prepare($event_name_query);
	$result->execute($event_params);
	$row = $result->fetch();
	
	$event_name = $row['Name'];
	$event_date_time = $row['Date_time'];
	$event_location = "Orlando";

	echo "<h2>$event_name</h2>
	<h4>$event_date_time, $event_location</h4>
	<hr>";
	
	$event_category = $row['Category_id'];
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
	
?>
	
<button type="submit" class="btn btn-primary">Join Event</button>
	
<?php include TEMPLATE_BOTTOM; ?>