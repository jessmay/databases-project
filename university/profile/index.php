<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>University Profile</title>

<?php include TEMPLATE_MIDDLE; 
	// TODO Make join button work
	// Show pictures

	$university_id = 2;
	
	$university_query = '
		SELECT *
		FROM university U
		WHERE U.University_id = :id
	';

	$university_params = array(':id' => $university_id);
	$result = $db->prepare($university_query);
	$result->execute($university_params);
	$row = $result->fetch();
	
	$university_name = $row['Name'];
	
	$location_query = '
		SELECT L.Name
		FROM location L, university_location UL
		WHERE UL.University_id = :id AND UL.Location_id = L.Location_id
	';
	$location_result = $db->prepare($location_query);
	$location_result->execute($university_params);
	$location_row = $location_result->fetch();
	$university_location = $location_row['Name'];
	
	echo "<h2>$university_name</h2>
	<h4>$university_location</h4>
	<hr>";
	
	$uni_student_count = $row['Student_count'];
	
	echo "<h4>Student Count</h4>
	<p>$uni_student_count</p>
	<br>";
	
	$uni_description = $row['Description'];
	
	echo "<h4>University Description</h4>
	<p>$uni_description</p>
	<br>";

?>
	
	<button type="submit" class="btn btn-primary">Join University</button>

<?php include TEMPLATE_BOTTOM; ?>