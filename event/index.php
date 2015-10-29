<?php include '../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
    <title>Find Event</title>

<?php include TEMPLATE_MIDDLE; ?>
    
<!-- TODO:
    1.)Implement the location results and Sort results in ascending order from distance away.
    2.)Filter out all results restricted to RSO members
    3.)If private, make sure to only allow memebers of the hosting university to see results. 
    4.)Be sure not to include any events that are not approved by a super admin.
 -->
    <h2>
        Find Event
    </h2>
    <hr>
        <form method="post">
            <div class="form-group">
                <label class="control-label" for="rsoName">Search for Event (Event Name, Location)</label>
                <input type="text" class="form-control" name="search" placeholder="ex: University of Central Florida">
            </div>
            
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

<?php
    if(isset($_POST['search'])){
        $search = $_POST['search'];
        $Name = '%'.$search.'%';
        $search_string = htmlentities($search);

        $search_name = "SELECT * 
                FROM Event E
                WHERE E.Name like :name";

        $event_name_params = array(':name' => $Name);
        $result_name = $db->prepare($search_name);
        $result_name->execute($event_name_params);
        $number = $result_name->rowCount();
        
        echo "<h3><strong>$number result(s) found searching for '$search_string'. </strong></h3><hr><br>";

        while($row = $result_name->fetch()){
            $Name =$row['Name'];
            $ID = $row['Event_id'];

            echo "<a href='/event/view?id=$ID'><h3><strong>$Name</strong></h3><hr></a>";
        }
    }
    
?>
<?php include TEMPLATE_BOTTOM; ?>