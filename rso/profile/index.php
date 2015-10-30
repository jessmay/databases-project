<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>RSO Profile Page</title>

<?php include TEMPLATE_MIDDLE; 

	// todo make sure user goes to same university as admin

	$rso_id = $_GET['id'];
	$url = $_SERVER['REQUEST_URI'];
	
	$user = $_SESSION['user'];
	$user_id =$user['User_id'];
	
	$user_can_join = false;

	$user_in_RSO_params = array(
		':RSO_id' => $rso_id,
		':user_id' => $user_id
	);
	
	$user_in_RSO_query = '
		SELECT COUNT(*) AS user_joined
		FROM rso_user R
		WHERE R.User_id = :user_id AND R.RSO_id = :RSO_id
	';
	
	$user_in_RSO_result = $db->prepare($user_in_RSO_query);
	$user_in_RSO_result->execute($user_in_RSO_params);
	$user_in_RSO_row = $user_in_RSO_result->fetch();
	$user_in_RSO = $user_in_RSO_row['user_joined'];

	if($user_in_RSO==0){
		$user_can_join = true;
	}
	
	$rso_query = '
		SELECT *
		FROM rso R
		WHERE R.RSO_id = :id
	';

	$rso_params = array(':id' => $rso_id);
	$result = $db->prepare($rso_query);
	$result->execute($rso_params);
	$row = $result->fetch();
	
	$rso_name = $row['Name'];
	
	echo "<h2>$rso_name</h2>
	<hr>";
	
	$university_query = '
		SELECT U.Name
		FROM university U, university_rso UR
		WHERE U.University_id = UR.University_id AND UR.RSO_id = :id
	';
	
	$uni_result = $db->prepare($university_query);
	$uni_result->execute($rso_params);
	$uni_row = $uni_result->fetch();
	
	$uni_name = $uni_row['Name'];
	
	echo "<h4>University</h4>
	<p>$uni_name</p>
	<br>";
	
	$admin_query = '
		SELECT U.First_name, U.Last_name
		FROM User U
		WHERE U.User_id = :admin_id
	';
	
	$admin_id = $row['Admin_id'];
	$admin_params = array(':admin_id' => $admin_id);
	$admin_result = $db->prepare($admin_query);
	$admin_result->execute($admin_params);
	$admin_row = $admin_result->fetch();
	
	$admin_first_name = $admin_row['First_name'];
	$admin_last_name = $admin_row['Last_name'];
	
	echo "<h4>Admin</h4>
	<p>$admin_first_name $admin_last_name</p>
	<br>";
	
	$member_count_query = '
		SELECT COUNT(*) AS Member_count
		FROM rso_user R
		WHERE R.RSO_id = :id
	';
	
	$member_result = $db->prepare($member_count_query);
	$member_result->execute($rso_params);
	$member_row = $member_result->fetch();
	
	$member_count = $member_row['Member_count'];
	
	echo "<h4>Number of Members</h4>
	<p>$member_count</p>
	<br>";
	
	function tryJoinRSO($db, $rso_id, $user_id){	
		$join_rso_params = array(
			':rso_id' => $rso_id,
			':user_id' => $user_id
		);
		$join_rso_query = '
			INSERT INTO RSO_user (
				RSO_id,
				User_id
			) VALUES (
				:rso_id,
				:user_id
			)
		';		
	
		$join_rso_result = $db->prepare($join_rso_query);
		$join_rso_result->execute($join_rso_params);
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['joinRSO'])) {
			$success = tryJoinRSO(
				$db,
				$rso_id,
				$user_id
			);
			$user_can_join=false;
		}
	}
	
?>

<?php if($user_can_join): ?>
	<form role="form" ="<?php echo $url; ?>" method="post">
		<button type="submit" name="joinRSO" class="btn btn-primary">Join RSO</button>
	</form>
<?php endif; ?>

<?php include TEMPLATE_BOTTOM; ?>