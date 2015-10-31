<?php include '../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
    <title>Find University</title>

<?php include TEMPLATE_MIDDLE; ?>
<?php include MAP_FUNCTIONS; ?>

<!-- TODO:
    1.) Sort results in ascending order from distance away.

 -->
    <h2>
        Find University
    </h2>
    <hr>
		<form method="post">
            <div class="form-group">
                <label class="control-label" for="rsoName">Search for University (University Name, City)</label>
                <input type="text" class="form-control" name="search" placeholder="ex: University of Central Florida">
            </div>
			
			<button type="submit" class="btn btn-primary">Search</button>
        </form>

<?php
     // TESTING NOTE: To see function results, change "$see_output" value to True

    $see_output = false;

    if(isset($_POST['search']) && trim($_POST['search']) != '' ){
        
        $search = $_POST['search'];
        $Name = '%'.$search.'%';
        $search_string = htmlentities($search);

        //We use google's geocode api to take in the place of interest
        //and see if we can return a valid result back from it.
        $search_lookup = lookup($search_string.", USA");

        if($see_output){
            print_r($search_lookup);
        }

        $search_name = "SELECT * 
                FROM University U
                WHERE U.Name like :name  AND U.University_id <> 1";

        $university_name_params = array(':name' => $Name);
        
        $result_name = $db->prepare($search_name);
        $result_name->execute($university_name_params);
        $number = $result_name->rowCount();
        
        echo "<h3><strong>$number result(s) found searching for '$search_string' by Name. </strong></h3><hr/>";

        while($row = $result_name->fetch()){
            $Name =$row['Name'];
            $ID = $row['University_id'];

            echo "<a href='/university/profile?id=$ID'><h3><strong>$Name</strong></h3></a><hr/>";
           
        }
        echo "<br><hr style='border: 1px solid #000;' />";
        // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
        if ($search_lookup['latitude'] == 'failed') {
            echo "<h3><strong>0 result(s) found searching for '$search_string' by Location. </strong></h3><hr/>";
        }

        else{

            $university_name_query = "SELECT U.Name
                    FROM university U
                    WHERE U.University_id = :id";

            $location_query = "SELECT *
                    FROM location L, university_location UL
                    WHERE UL.Location_id = L.Location_id";

            $location_result = $db->prepare($location_query);
            $location_result->execute($university_name_params);

            $count = 0;
            $answer = Array();

            while($location_row = $location_result->fetch()){
                $latitude =$location_row['Latitude'];
                $longitude =$location_row['Longitude'];
                $ID = $location_row['University_id'];

                $university_id_params = array(':id' => $ID);
                $result_name = $db->prepare($university_name_query);
                $result_name->execute($university_id_params);
                $result_name_array = $result_name->fetch();
                $university_name = $result_name_array['Name'];
                $distance = distanceCalc($search_lookup['latitude'],$search_lookup['longitude'],$latitude,$longitude);

                if($distance <= 16.0){
                    $count++;
                    array_push($answer, Array
                                            (       
                                                'Name' => $university_name,
                                                'ID' => $ID,
                                                'Distance' => $distance
                                     
                                            ));

                }

                if($see_output){
                    echo "<br>The distance is ".$distance."<br>";
                    echo "<br>".$university_name."<br>";
                    
                    echo "<h3><strong>Lat: $latitude, Lng: $longitude</strong></h3><hr><br>";
                }
            }
            if($see_output){
                print_r($answer);
                echo "<br>";
            }
            usort($answer, "cmp");
            if($see_output){  
                print_r($answer);
            }
            echo "<h3><strong>$count result(s) found searching for '$search_string' by Location. </strong></h3><hr/>";

            for($i = 0, $size = count($answer); $i < $size; $i++){
                $answer_id = $answer[$i]['ID'];
                $answer_name = $answer[$i]['Name'];
                echo "<a href='/university/profile?id=$answer_id'><h3><strong>$answer_name</strong></h3><hr></a>";
            }
        }
        
    }
    
?>

<?php
function cmp($a, $b)
{
    if ($a['Distance'] == $b['Distance']) {
        return 0;
    }
    return ($a['Distance'] < $b['Distance']) ? -1 : 1;
}
?>

<?php include TEMPLATE_MAP; ?>
<?php include TEMPLATE_BOTTOM; ?>


