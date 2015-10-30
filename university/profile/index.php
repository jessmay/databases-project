<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>University Profile</title>

<?php include TEMPLATE_MIDDLE; 

	$url = $_SERVER['REQUEST_URI'];
	
	$university_id = $_GET['id'];
	
	$user = $_SESSION['user'];
	$user_id =$user['User_id'];
	
	$user_can_join = false;

	$user_in_university_params = array(
		':user_id' => $user_id
	);
	
	$user_in_university_query = '
		SELECT U.University_id
		FROM user U
		WHERE U.User_id = :user_id
	';
	
	$user_in_university_result = $db->prepare($user_in_university_query);
	$user_in_university_result->execute($user_in_university_params);
	$user_in_university_row = $user_in_university_result->fetch();
	$user_in_university = $user_in_university_row['University_id'];

	if($user_in_university == 1){
		$user_can_join = true;
	}
	
	$university_query = '
		SELECT *
		FROM university U
		WHERE U.University_id = :id
	';

	$university_params = array(':id' => $university_id);
	$result = $db->prepare($university_query);
	$result->execute($university_params);
	$row = $result->fetch();
	
	$picture_query = '
		SELECT P.Url
		FROM picture P, university_picture UP
		WHERE UP.University_id = :id AND UP.Picture_id = P.Picture_id
	';
	
	$picture_result = $db->prepare($picture_query);
	$picture_result->execute($university_params);
	$picture_row = $picture_result->fetch();
	$university_picture = $picture_row['Url'];
	echo "<img src='$university_picture' class='img-thumbnail' width=100 height=100>";
	
	
	$university_name = $row['Name'];
	
	$location_query = '
		SELECT L.Name, L.Latitude, L.Longitude
		FROM location L, university_location UL
		WHERE UL.University_id = :id AND UL.Location_id = L.Location_id
	';
	$location_result = $db->prepare($location_query);
	$location_result->execute($university_params);
	$location_row = $location_result->fetch();
	$university_location = $location_row['Name'];
	$university_latitude = $location_row['Latitude'];
	$university_longitude = $location_row['Longitude'];
	
	echo "<h2>$university_name</h2>
	<h4>$university_location</h4>
	<hr>";
	
	echo "<img src='http://maps.googleapis.com/maps/api/staticmap?center=$university_latitude,+$university_longitude&zoom=15&scale=false&size=300x300&maptype=roadmap&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:1%7C$university_latitude,+$university_longitude'>";
	
	$uni_student_count = $row['Student_count'];
	
	echo "<h4>Student Count</h4>
	<p>$uni_student_count</p>
	<br>";
	
	$uni_description = $row['Description'];
	
	echo "<h4>University Description</h4>
	<p>$uni_description</p>
	<br>";
	
	$joined_this_session = false;
	
	function tryJoinUniversity($db, $university_id, $user_id){
		
		$join_university_params = array(
			':university_id' => $university_id,
			':user_id' => $user_id
		);
		$join_university_query = '
			UPDATE User U
			SET U.University_id = :university_id
			WHERE U.User_id = :user_id
		';		
	
		$join_university_result = $db->prepare($join_university_query);
		$join_university_result->execute($join_university_params);
		
		return true;
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['joinUniversity'])) {
			$joined_this_session = tryJoinUniversity(
				$db,
				$university_id,
				$user_id
			);
			$user_can_join = false;
		}
	}
	
?>

<?php if($user_can_join): ?>
	<form role="form" action="" method="post">
		<button type="submit" name="joinUniversity" class="btn btn-primary">Join University</button>
	</form>
<?php endif; ?>

<?php include TEMPLATE_BOTTOM; ?>