<?php include '../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
    <title>Find Event</title>

<?php include TEMPLATE_MIDDLE; ?>
<?php include MAP_FUNCTIONS; ?>
    
    <h2>
        Find Event
    </h2>
    <hr>
        <form method="post">
            <div class="form-group">
                <label class="control-label" for="rsoName">Search for Event (Event Name, Location)</label>
                <input type="text" class="form-control" name="search" placeholder="ex: Career Fair">
            </div>
            
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

<?php
    
    $see_output = false;

    if(isset($_POST['search'])){
        if(!$_SESSION){
            echo '<h3>Sorry. You aren\'t signed in.';
            echo ' <a href="/">Sign in</a> to see events.</h3>';
        }
        else{

            $search = $_POST['search'];
            $Name = '%'.$search.'%';
            $search_string = htmlentities($search);

            $search_lookup = lookup($search_string);

            if($see_output){
                print_r($search_lookup);
            }
            $user_id = $_SESSION['user']['User_id'];

            //Used to total up all of the number of results
            //for each search area (name, location)
            $rso_count = 0;
            $private_count = 0;
            $public_count = 0;
            $final_count = 0;

            //RSO EVENT NAME SEARCH
            $rso_id_query = "SELECT RU.RSO_id
                                FROM rso_user RU
                                WHERE RU.User_id = :id ";

            $rso_id_params = array(':id' => $user_id);
            $result_id = $db->prepare($rso_id_query);
            $result_id -> execute($rso_id_params);

            $approved_rso_event_query = "SELECT * 
                    FROM Event E
                    WHERE E.Name like :name AND E.Approved = 1 AND E.Type = 2 AND E.RSO_id = :id";

    
            $user_rsos_Event_name = array();

            while ($rso_id_row = $result_id->fetch()) {
                $rso_id = $rso_id_row['RSO_id'];

                $rso_name_params = array(':id' => $rso_id);

                $rso_name_query = "SELECT R.Name
                                FROM rso R
                                WHERE R.RSO_id = :id ";

                $result = $db->prepare($rso_name_query);
                $result->execute($rso_name_params);
                $result_name_rso = $result->fetch();

                $rso_event_name_params = array(':name' => $Name,
                                                ':id' => $rso_id);
                $result_name = $db->prepare($approved_rso_event_query);
                $result_name->execute($rso_event_name_params);
                $result_name_array = $result_name->fetch();
                array_push($user_rsos_Event_name, array(
                                                        'Name' => $result_name_array['Name'],
                                                        'ID' => $result_name_array['Event_id'],
                                                        'RSO' => $result_name_rso['Name']
                                                        )
                            );
                

            }
            
            for($i = 0, $size = count($user_rsos_Event_name); $i < $size; $i++){
                if($user_rsos_Event_name[$i]['ID']){
                    $rso_count++;
                }
                
            }
            //**END RSO EVENT NAME SEARCH

            //UNIVERSITY EVENT NAME SEARCH
            $user_university_id_query = "SELECT U.University_id
                                FROM User U
                                WHERE U.User_id = :id ";

            $user_university_params = array(':id' => $user_id);
            $result_id = $db->prepare($user_university_id_query);
            $result_id ->execute($user_university_params);
            $university_row = $result_id->fetch();

            $user_university_id = $university_row['University_id'];

            $university_event_name_params = array(
                                                    ':name' => $Name,
                                                    ':id' => $user_university_id
                                                    );

            $approved_private_event_query = "SELECT * 
                    FROM Event E, university_event UE
                    WHERE E.Name like :name AND E.Approved = 1 AND E.Type = 1 AND UE.University_id = :id AND E.Event_id = UE.Event_id";

            $result_private_event_name = $db->prepare($approved_private_event_query);
            $result_private_event_name->execute($university_event_name_params);
            $private_count = $result_private_event_name->rowCount();

            //**END UNIVERSITY EVENT NAME SEARCH

            //PUBLIC EVENT NAME SEARCH
            $public_event_name_params = array(':name' => $Name);

            $approved_public_event_query = "SELECT * 
                    FROM Event E, university_event UE
                    WHERE E.Name like :name AND E.Approved = 1 AND E.Type = 3 AND E.Event_id = UE.Event_id";

            $result_public_event_name = $db->prepare($approved_public_event_query);
            $result_public_event_name->execute($public_event_name_params);
            $public_count = $result_public_event_name->rowCount();
            //**END PUBLIC EVENT NAME SEARCH

            $private_answer = array();
            $public_answer = array();
      
                           
            $user_private_Event_name = array();
            while ($private_event_row2 = $result_private_event_name->fetch()){

                array_push($user_private_Event_name, array(
                                                    'Name' => $private_event_row2['Name'],
                                                    'ID' => $private_event_row2['Event_id'],
                                                    'University_id' => $private_event_row2['University_id']
                                                    )
                        );
                

            }

            
            for($i = 0, $size2 = count($user_private_Event_name); $i < $size2; $i++){
                $answer_name = $user_private_Event_name[$i]['Name'];
                $answer_id = $user_private_Event_name[$i]['ID'];

                $university = $user_private_Event_name[$i]['University_id'];

                $university_id_params = array(':id' => $university);

                $university_name_query = "SELECT U.Name
                FROM university U
                WHERE U.University_id = :id";
                
                $result_name = $db->prepare($university_name_query);
                $result_name->execute($university_id_params);
                $result_name_array = $result_name->fetch();
                $university_name = $result_name_array['Name'];
   
                array_push($private_answer, array
                                        (       
                                            'Name' => $answer_name,
                                            'ID' => $answer_id,
                                            'University' => $university_name
                                 
                                        ));
                    
                
            }
                

            $user_public_Event_name_array = array();
            while ($public_event_row2 = $result_public_event_name->fetch()){
                array_push($user_public_Event_name_array, array(
                                                    'Name' => $public_event_row2['Name'],
                                                    'ID' => $public_event_row2['Event_id'],
                                                    'University' => $public_event_row2['University_id']
                                                    )
                        );

            }
            
            for($i = 0, $size3 = count($user_public_Event_name_array); $i < $size3; $i++){
                
                $answer_name = $user_public_Event_name_array[$i]['Name'];
                $answer_id = $user_public_Event_name_array[$i]['ID'];

                $university = $user_public_Event_name_array[$i]['University'];

                $university_id_params = array(':id' => $university);

                $university_name_query = "SELECT U.Name
                FROM university U
                WHERE U.University_id = :id";

                
                $result_name = $db->prepare($university_name_query);
                $result_name->execute($university_id_params);
                $result_name_array = $result_name->fetch();
                $university_name = $result_name_array['Name'];
                    
                array_push($public_answer, array
                                        (       
                                            'Name' => $answer_name,
                                            'ID' => $answer_id,
                                            'University' => $university_name
                                 
                                        ));                    
                
            }

            $private_count = count($private_answer);
            $public_count = count($public_answer);

            if($see_output){
                print_r("<br>");
                print_r($rso_count);
                print_r("<br>");
                print_r($private_count);
                print_r("<br>");
                print_r($public_count);
                print_r("<br>");

                print_r("<br>");
                print_r($user_rsos_Event_name);
            }
            

            $final_count = $rso_count + $private_count + $public_count;

            if($final_count == 1){
                    echo "<h3><strong>$final_count result found searching for '$search_string' by Name. </strong></h3><hr/>";
                }

            else{
                    echo "<h3><strong>$final_count results found searching for '$search_string' by Name. </strong></h3><hr/>";
                }

            if($rso_count > 0){
                echo "<h4><strong>RSO Events </strong></h4><hr>";
                //Outputting all the resulting events that were returned
                echo '<div style="margin-left: 3em;">';
                 for($i = 0, $size = count($user_rsos_Event_name); $i < $size; $i++){

                    $answer_id = $user_rsos_Event_name[$i]['ID'];
                    $answer_name = $user_rsos_Event_name[$i]['Name'];
                    $answer_rso_name = $user_rsos_Event_name[$i]['RSO'];
                    if($answer_id == NULL)
                        continue;
                    else{
                        echo "<a href='/event/view?id=$answer_id'><h3><strong>$answer_name</strong></a></h3>Hosted by $answer_rso_name<hr>";
                    }
                    
                }

                echo "</div>";  
            }

            if(count($private_answer) > 0){
                    echo "<h4><strong>Private Events </strong></h4><hr>";
                    echo '<div style="margin-left: 3em;">';
                    for($i = 0, $size2 = count($private_answer); $i < $size2; $i++){
                        $answer_id = $private_answer[$i]['ID'];
                        $answer_name = $private_answer[$i]['Name'];
                        $answer_university_name = $private_answer[$i]['University'];
                        echo "<a href='/event/view?id=$answer_id'><h3><strong>$answer_name</strong></a></h3>Hosted by $answer_university_name<hr>";
                    }
                    echo "</div>";
                }
                
                if(count($public_answer) > 0){
                    echo "<h4><strong>Public Events </strong></h4><hr>";
                    echo '<div style="margin-left: 3em;">';
                    for($i = 0, $size3 = count($public_answer); $i < $size3; $i++){
                        $answer_id = $public_answer[$i]['ID'];
                        $answer_name = $public_answer[$i]['Name'];
                        $answer_university_name = $public_answer[$i]['University'];
                        echo "<a href='/event/view?id=$answer_id'><h3><strong>$answer_name</strong></a></h3>Hosted by $answer_university_name<hr>";
                    }
                    echo "</div>";
                }
            
            echo "<br><hr style='border: 1px solid #000;' />";
        
            //The following is for showing events by location

            if ($search_lookup['latitude'] == 'failed') {
                echo "<h3><strong>0 results found searching for '$search_string' by Location. </strong></h3><hr/>";
            }

            else{

                $rso_count = 0;
                $private_count = 0;
                $public_count = 0;
                $final_count = 0;


                //Gets all the RSOs that a user is in
                $rso_id_query = "SELECT RU.RSO_id
                                    FROM rso_user RU
                                    WHERE RU.User_id = :id ";


                $rso_id_params = array(':id' => $user_id);
                $result_id = $db->prepare($rso_id_query);
                $result_id -> execute($rso_id_params);

                //Looks up locations of the RSO events that the User is a part of
                $location_query = "SELECT *
                        FROM location L, event_location EL, Event E
                        WHERE EL.Location_id = L.Location_id AND E.Approved = 1 AND E.Type = 2 AND E.RSO_id = :id AND EL.Event_id = E.Event_id";

                $user_rsos_Event_location = array();

                while($rso_id_location_row = $result_id->fetch()){
                    $rso_id = $rso_id_location_row['RSO_id'];

                    $rso_event_location_params = array(':id' => $rso_id);
                    $result_location = $db->prepare($location_query);
                    $result_location->execute($rso_event_location_params);
                    $result_location_array = $result_location->fetch();

                    $rso_name_params = array(':id' => $rso_id);

                    $rso_name_query = "SELECT R.Name
                                    FROM rso R
                                    WHERE R.RSO_id = :id ";

                    $result = $db->prepare($rso_name_query);
                    $result->execute($rso_name_params);
                    $result_name_rso = $result->fetch();
                    array_push($user_rsos_Event_location, array(
                                                            'Name' => $result_location_array['Name'],
                                                            'ID' => $result_location_array['Event_id'],
                                                            'Latitude' => $result_location_array['Latitude'],
                                                            'Longitude' => $result_location_array['Longitude'],
                                                            'RSO' => $result_name_rso['Name']
                                                            )
                                );

                }


                //The following looks up location of University Events
                $university_event_location_params = array(':id' => $user_university_id);
                $location_query2 = "SELECT *
                        FROM location L, event_location EL, Event E, university_event UE
                        WHERE EL.Location_id = L.Location_id AND E.Approved = 1 AND E.Type = 1 AND UE.University_id = :id 
                                                AND EL.Event_id = E.Event_id AND E.Event_id = UE.Event_id";

                $result_private_event_location = $db->prepare($location_query2);
                $result_private_event_location->execute($university_event_location_params);
                $private_count = $result_private_event_location->rowCount();


                $location_query3 = "SELECT *
                        FROM location L, event_location EL, Event E, university_event UE
                        WHERE EL.Location_id = L.Location_id AND E.Approved = 1 AND E.Type = 3 
                                                AND EL.Event_id = E.Event_id AND E.Event_id = UE.Event_id";

                $result_public_event_location = $db->prepare($location_query3);
                $result_public_event_location->execute();
                $public_count = $result_public_event_location->rowCount();

                $rso_answer = array();
                $private_answer = array();
                $public_answer = array();
          
                for($i = 0, $size = count($user_rsos_Event_location); $i < $size; $i++){
                    $answer_id = $user_rsos_Event_location[$i]['ID'];
                    $answer_name = $user_rsos_Event_location[$i]['Name'];
                    $latitude = $user_rsos_Event_location[$i]['Latitude'];
                    $longitude = $user_rsos_Event_location[$i]['Longitude'];
                    $rso = $user_rsos_Event_location[$i]['RSO'];

                    $distance = distanceCalc($search_lookup['latitude'],$search_lookup['longitude'],$latitude, $longitude);

                    if($distance <= 16.0){
                        
                        array_push($rso_answer, array
                                                (       
                                                    'Name' => $answer_name,
                                                    'ID' => $answer_id,
                                                    'Distance' => $distance,
                                                    'RSO' => $rso,
                                                    
                                         
                                                ));
                        if($see_output){
                            echo "<br>The distance is ".$distance."<br>";
                            echo "<br>".$answer_name."<br>";
                            
                            echo "<h3><strong>Lat: $latitude, Lng: $longitude</strong></h3><hr><br>";
                        }

                    }
                }
                               
                $user_private_Event_location = array();
                while ($private_event_row2 = $result_private_event_location->fetch()){

                    array_push($user_private_Event_location, array(
                                                        'Name' => $private_event_row2['Name'],
                                                        'ID' => $private_event_row2['Event_id'],
                                                        'Latitude' => $private_event_row2['Latitude'],
                                                        'Longitude' => $private_event_row2['Longitude'],
                                                        'University_id' => $private_event_row2['University_id']
                                                        )
                            );
                    

                }

                

                for($i = 0, $size2 = count($user_private_Event_location); $i < $size2; $i++){
                    $answer_name = $user_private_Event_location[$i]['Name'];
                    $answer_id = $user_private_Event_location[$i]['ID'];

                    $latitude = $user_private_Event_location[$i]['Latitude'];
                    $longitude = $user_private_Event_location[$i]['Longitude'];
                    $university = $user_private_Event_location[$i]['University_id'];

                    $university_id_params = array(':id' => $university);

                    $university_name_query = "SELECT U.Name
                    FROM university U
                    WHERE U.University_id = :id";
                    
                    $result_name = $db->prepare($university_name_query);
                    $result_name->execute($university_id_params);
                    $result_name_array = $result_name->fetch();
                    $university_name = $result_name_array['Name'];

                    $distance = distanceCalc($search_lookup['latitude'],$search_lookup['longitude'],$latitude,$longitude);

                    if($distance <= 16.0){
                        
                        array_push($private_answer, array
                                                (       
                                                    'Name' => $answer_name,
                                                    'ID' => $answer_id,
                                                    'Distance' => $distance,
                                                    'University' => $university_name
                                         
                                                ));
                        if($see_output){
                            echo "<br>The distance is ".$distance."<br>";
                            echo "<br>".$answer_name."<br>";
                            
                            echo "<h3><strong>Lat: $latitude, Lng: $longitude</strong></h3><hr><br>";
                        }
                        
                    }
                }
                    

                $user_public_Event_location_array = array();
                while ($public_event_row2 = $result_public_event_location->fetch()){
                    array_push($user_public_Event_location_array, array(
                                                        'Name' => $public_event_row2['Name'],
                                                        'ID' => $public_event_row2['Event_id'],
                                                        'Latitude' => $public_event_row2['Latitude'],
                                                        'Longitude' => $public_event_row2['Longitude'],
                                                        'University' => $public_event_row2['University_id']
                                                        )
                            );

                }
                
                for($i = 0, $size3 = count($user_public_Event_location_array); $i < $size3; $i++){
                    
                    $answer_name = $user_public_Event_location_array[$i]['Name'];
                    $answer_id = $user_public_Event_location_array[$i]['ID'];

                    $latitude = $user_public_Event_location_array[$i]['Latitude'];
                    $longitude = $user_public_Event_location_array[$i]['Longitude'];

                    $university = $user_public_Event_location_array[$i]['University'];

                    $university_id_params = array(':id' => $university);

                    $university_name_query = "SELECT U.Name
                    FROM university U
                    WHERE U.University_id = :id";

                    
                    $result_name = $db->prepare($university_name_query);
                    $result_name->execute($university_id_params);
                    $result_name_array = $result_name->fetch();
                    $university_name = $result_name_array['Name'];

                    $distance = distanceCalc($search_lookup['latitude'],$search_lookup['longitude'],$latitude,$longitude);

                    if($distance <= 16.0){
                        
                        array_push($public_answer, array
                                                (       
                                                    'Name' => $answer_name,
                                                    'ID' => $answer_id,
                                                    'Distance' => $distance,
                                                    'University' => $university_name
                                         
                                                ));
                        if($see_output){
                            echo "<br>The distance is ".$distance."<br>";
                            echo "<br>".$answer_name."<br>";
                            
                            echo "<h3><strong>Lat: $latitude, Lng: $longitude</strong></h3><hr><br>";
                        }
                        
                    }
                }

                $rso_count = count($rso_answer);
                $private_count = count($private_answer);
                $public_count = count($public_answer);

                if($see_output){
                    echo "<br> The size of rso event is: ";
                    print_r(count($user_rsos_Event_location));
                    echo "<br>";

                    echo "<br> The size of private event is: ";

                    print_r(count($user_private_Event_location));
                    echo "<br>";

                    echo "<br> The size of public event is: ";
                    print_r(count($user_public_Event_location_array));
                    echo "<br>"; 
                }
            
                $final_count = $rso_count + $private_count + $public_count;

                if($final_count == 1){
                    echo "<h3><strong>$final_count result found searching for '$search_string' by Location. </strong></h3><hr/>";
                }

                else{
                    echo "<h3><strong>$final_count results found searching for '$search_string' by Location. </strong></h3><hr/>";
                }

                if($see_output){
                    print_r($rso_answer);
                    echo "<br>";

                    print_r($private_answer);
                    echo "<br>";

                    print_r($public_answer);
                    echo "<br>";
                }

                usort($rso_answer, "cmp");
                usort($private_answer, "cmp");
                usort($public_answer, "cmp");

                if($see_output){
                    print_r($rso_answer);
                    echo "<br>";

                    print_r($private_answer);
                    echo "<br>";

                    print_r($public_answer);
                    echo "<br>";
                }

                //Outputting all the resulting events that were returned
                if(count($rso_answer) > 0){
                    echo "<h4><strong>RSO Events </strong></h4><hr>"; 
                    echo '<div style="margin-left: 3em;">';
                    for($i = 0, $size = count($rso_answer); $i < $size; $i++){
                        $answer_id = $rso_answer[$i]['ID'];
                        $answer_name = $rso_answer[$i]['Name'];
                        $answer_rso_name = $rso_answer[$i]['RSO'];
                        echo "<a href='/event/view?id=$answer_id'><h3><strong>$answer_name</strong></a></h3>Hosted by $answer_rso_name<hr>";
                    }

                    echo "</div>";  
                }
                
                if(count($private_answer) > 0){
                    echo "<h4><strong>Private Events </strong></h4><hr>";
                    echo '<div style="margin-left: 3em;">';
                    for($i = 0, $size2 = count($private_answer); $i < $size2; $i++){
                        $answer_id = $private_answer[$i]['ID'];
                        $answer_name = $private_answer[$i]['Name'];
                        $answer_university_name = $private_answer[$i]['University'];
                        echo "<a href='/event/view?id=$answer_id'><h3><strong>$answer_name</strong></a></h3>Hosted by $answer_university_name<hr>";
                    }
                    echo "</div>";
                }
                
                if(count($public_answer) > 0){
                    echo "<h4><strong>Public Events </strong></h4><hr>";
                    echo '<div style="margin-left: 3em;">';
                    for($i = 0, $size3 = count($public_answer); $i < $size3; $i++){
                        $answer_id = $public_answer[$i]['ID'];
                        $answer_name = $public_answer[$i]['Name'];
                        $answer_university_name = $public_answer[$i]['University'];
                        echo "<a href='/event/view?id=$answer_id'><h3><strong>$answer_name</strong></a></h3>Hosted by $answer_university_name<hr>";
                    }
                    echo "</div>";
                }
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