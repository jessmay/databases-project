<?php include '../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
    <title>Find RSO</title>

<?php include TEMPLATE_MIDDLE; ?>
<?php include MAP_FUNCTIONS; ?>
    <h2>
        Find RSO
    </h2>

    <hr>
        <form method="post">
            <div class="form-group">
                <label class="control-label" for="rsoName">Search for RSO (RSO Name)</label>
                <input type="text" class="form-control" name="search" placeholder="ex: Student Government Association (SGA)">
            </div>
            
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

<?php
    $see_output = false;

    if($see_output){
        print_r($_SESSION);
    }

    if(isset($_POST['search']) && trim($_POST['search']) != '' ){
        
        if(!$_SESSION){
            echo '<h3>Sorry. You aren\'t signed in.';
            echo ' <a href="/">Sign in</a> to see your university\'s RSO\'s.</h3>';
        }
        else
        {

            $user_id = $_SESSION['user']['User_id'];

            $user_university_id_query = "SELECT U.University_id
                                FROM User U
                                WHERE U.User_id = :id ";

            $user_university_params = array(':id' => $user_id);
            $result_id = $db->prepare($user_university_id_query);
            $result_id -> execute($user_university_params);
            $university_row = $result_id->fetch();

            $user_university_id = $university_row['University_id'];

            if($see_output){
                print_r("<br>User ID = ".$user_id."<br>");
                print_r("User University ID = ".$user_university_id);
            }
            
            if($user_university_id == 1){
                echo '<h3>We noticed that you haven\'t joined a university yet.';
                echo ' <a href="/university/">Find your university</a>.</h3>';
            }
            else{

                $search = $_POST['search'];
                $Name = '%'.$search.'%';
                $search_string = htmlentities($search);

                $university_params = array('id' => $user_university_id);
                $university_name_query = "SELECT U.Name
                                    FROM University U
                                    WHERE U.University_id = :id";
                $result_university_name = $db->prepare($university_name_query);
                $result_university_name->execute($university_params);
                $university_name_row = $result_university_name->fetch();
                $university_name = $university_name_row['Name'];
                
                $search_query = "SELECT * 
                        FROM rso R, university_rso UR 
                        WHERE R.Name like :name AND UR.University_id = :id AND R.RSO_id = UR.RSO_id";

                $rso_params = array(
                            ':name' => $Name,
                            'id' => $user_university_id
                                    );
                $result_name = $db->prepare($search_query);
                $result_name->execute($rso_params);
                $number = $result_name->rowCount();
                
                if($number ==  1){
                    echo "<h3><strong>$number result found searching $university_name for '$search_string'. </strong></h3><hr/>";
                }
                else{
                    echo "<h3><strong>$number results found searching $university_name for '$search_string'. </strong></h3><hr/>";
                }

                while($row = $result_name->fetch()){
                    $Name =$row['Name'];
                    $ID = $row['RSO_id'];

                    echo "<a href='/rso/profile?id=$ID'><h3><strong>$Name</strong></h3><hr></a>";
                }
            }
            
        }
    }
        
    
?>
<?php include TEMPLATE_BOTTOM; ?>