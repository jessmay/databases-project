<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Event View Page</title>

<?php include TEMPLATE_MIDDLE;
	// TODO 
	// RSO association with RSO event
	// ratings - stars
	
	//Events: Type: 1 - Private; 2 - RSO; 3 - Public
	
	$user = $_SESSION['user'];
	$user_id =$user['User_id'];
	$event_id = $_GET['id'];
	$url = $_SERVER['REQUEST_URI'];
	
	$user_can_join = false;
	$join_event_success=false;
	$create_comment_success=false;
	$create_rating_success=false;
	$message="";
	$rating=null;
	
	// Check if the user can join this event
	$user_event_query = '
		SELECT COUNT(*) AS userParticipating
		FROM event_user EU
		WHERE EU.Event_id = :event_id AND EU.User_id = :user_id
	';
	
	$user_event_params = array(
		':event_id' => $event_id,
		':user_id' => $user_id
	);
	$user_event_results = $db->prepare($user_event_query);
	$user_event_results->execute($user_event_params);
	$user_event_row = $user_event_results->fetch();
	
	if($user_event_row['userParticipating'] == 0){
		$user_can_join = true;
	}

	// Get event details
	$event_query = '
		SELECT *
		FROM Event E
		WHERE E.Event_id = :id
	';

	$event_params = array(':id' => $event_id);
	$result = $db->prepare($event_query);
	$result->execute($event_params);
	$row = $result->fetch();
	
	//Check if this is a private event
	$event_type = $row['Type'];
	if($event_type == 1){
		// Get University hosting this event
		$event_university_query = '
			SELECT UE.University_id
			FROM university_event UE
			WHERE UE.Event_id = :event_id
		';
		$event_university_params = array(':event_id' => $event_id);
		$event_university_result = $db->prepare($event_university_query);
		$event_university_result->execute($event_university_params);
		$event_university_row = $event_university_result->fetch();
		$ni_id = $event_university_row['University_id'];
		$u_id = $user['University_id'];
		echo "<p>Enter private event redirect $ni_id - $u_id</p>";
	
		// Verify user can view this event, if not, redirect to home page
		if($user['University_id'] == null || $user['University_id'] != $event_university_row['University_id']){
			echo "<p>Enter private event redirect</p>";
			 header('Location: /');
			 exit();
		}
	}
	else if($event_type == 2){ // TODO check against RSO
	
	}
	
	$event_name = $row['Name'];
	$event_date_time = $row['Date_time'];
	
	$location_query = '
		SELECT L.Name, L.Latitude, L.Longitude
		FROM location L, event_location EL
		WHERE EL.Event_id = :id AND EL.Location_id = L.Location_id
	';
	$location_result = $db->prepare($location_query);
	$location_result->execute($event_params);
	$location_row = $location_result->fetch();
	$event_location = $location_row['Name'];
	$event_latitude = $location_row['Latitude'];
	$event_longitude = $location_row['Longitude'];

	echo "<h2>$event_name</h2>
	<h4>$event_date_time, $event_location</h4>
	<hr>";
	
	echo "<img src='http://maps.googleapis.com/maps/api/staticmap?center=$event_latitude,+$event_longitude&zoom=15&scale=false&size=300x300&maptype=roadmap&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:1%7C$event_latitude,+$event_longitude'>";
	
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
	<hr>";
	
	function tryCreateRating($db, $current_user_id, $event_id, $rating){	
		$valid_rating_params = array(
			':user_id' => $current_user_id,
			':event_id' => $event_id
		);
		$valid_rating_query = '
			SELECT COUNT(*) AS Rating_exists
			FROM rating R
			WHERE R.Event_id = :event_id AND R.User_id = :user_id
		';
		$valid_rating_result = $db->prepare($valid_rating_query);
		$valid_rating_result->execute($valid_rating_params);
		$valid_rating_row = $valid_rating_result->fetch();
		$rating_exists = $valid_rating_row['Rating_exists'];
		
		if($rating_exists >= 1){
			return false;
		}
		else {	
			$create_rating_params = array(
				':user_id' => $current_user_id,
				':event_id' => $event_id,
				':rating' => $rating
			);
			$create_rating_query = '
				INSERT INTO Rating (
					User_id,
					Event_id,
					Rating
				) VALUES (
					:user_id,
					:event_id,
					:rating
				)
			';
			
			$rating_result = $db
				->prepare($create_rating_query)
				->execute($create_rating_params);
				
			return true;
		}
	}
	
	function tryPostComment($db, $current_user_id, $event_id, $message){
	
		$sql_date = date("Y-m-d H:i:s");
	
		$create_comment_params = array(
			':user_id' => $current_user_id,
			':event_id' => $event_id,
			':date' => $sql_date,
			':message' => $message
		);
		$create_comment_query = '
			INSERT INTO Comment (
				User_id,
				Event_id,
				Date,
				Message
			) VALUES (
				:user_id,
				:event_id,
				:date,
				:message
			)
		';
		
		$comment_result = $db
            ->prepare($create_comment_query)
            ->execute($create_comment_params);
			
		return true;
	}
	
	function tryJoinEvent($db, $event_id, $user_id){

		$join_event_params = array(
			':user_id' => $user_id,
			':event_id' => $event_id
		);
		$user_previously_joined_query = '
			SELECT COUNT(*) AS user_joined
			FROM Event_user E
			WHERE E.Event_id = :event_id AND E.User_id = :user_id
		';
		$join_event_query = '
			INSERT INTO Event_user (
				Event_id,
				User_id
			) VALUES (
				:event_id,
				:user_id
			)
		';
		
		$user_previously_joined_result = $db->prepare($user_previously_joined_query);
		$user_previously_joined_result->execute($join_event_params);
		$user_joined_row = $user_previously_joined_result->fetch();
		$user_joined = $user_joined_row['user_joined'];
		
		if(!$user_joined){
			$join_event_result = $db
			->prepare($join_event_query)
			->execute($join_event_params);
			
			return true;
		}
		else {
			return false;
		}
		
	}
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['joinEvent'])) {
			$join_event_success = tryJoinEvent(
				$db,
				$event_id,
				$user_id
			);
			$user_can_join = false;
		}
		elseif(isset($_POST['createComment'])) {
            $create_comment_success = tryPostComment(
                $db,
                $user_id,
				$event_id,
                $_POST['message']
            );
        }
		elseif(isset($_POST['createRating'])) {
			$create_rating_success = tryCreateRating(
				$db,
				$user_id,
				$event_id,
				$_POST['rating']
			);
		}
	}
	
?>



<?php
	$rating = $rating ? htmlentities($_POST['rating']) : '';
?>
<p>
	<form role="form" action"" method="post">
		<div class="row">
			<div class="form-group">
				<label class="control-label" for="rating">How would you rate this event? (1-5 where 1 is worst and 5 is best)</label>
				<div class="input-group">
					<input type="text" class="form-control" id="rating" name="rating" placeholder="Input a rating from 1-5 here." size="20" maxlength="1" required value="<?=$rating?>">
					<span class="input-group-btn">	
						<button type="submit" name="createRating" class="btn btn-primary">Submit Rating</button>
					</span>
				</div>
			</div>
		</div>
	</form>
</p>
<?php
	$comment_query = '
		SELECT *
		FROM comment C
		WHERE C.Event_id = :id
	';
	
	$comment_result = $db->prepare($comment_query);
	$comment_result->execute($event_params);
	
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
    $message = $message ? htmlentities($_POST['message']) : '';
?>
<p>
	<form role="form" action"" method="post">
		<div class="row">
			<div class="form-group">
				<label class="control-label" for="message">Add a comment</label>
				<div class="input-group">
					<input type="text" class="form-control" id="message" name="message" placeholder="Type your comment here." size="160" maxlength="160" required value="<?=$message?>">
					<span class="input-group-btn">	
						<button type="submit" name="createComment" class="btn btn-primary">Post Comment</button>
					</span>
				</div>
			</div>				
		</div>
	</form>
</p>

<?php if($user_can_join): ?>
	<form role="form" action="<?php echo $url; ?>" method="post">
		<button type="submit" name="joinEvent" class="btn btn-primary">Join Event</button>
	</form>
<?php endif; ?>

<a class="facebook-share-button" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode($url); ?>">Share on Facebook</a>
	
<?php include TEMPLATE_BOTTOM; ?>