<?php include '../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
    <title>Find RSO</title>

<?php include TEMPLATE_MIDDLE; ?>

    <h2>
        Find RSO
    </h2>
    <hr>
        <form method="post">
            <div class="form-group">
                <label class="control-label" for="rsoName">Search for RSO (RSO Name, University, City)</label>
                <input type="text" class="form-control" name="search" placeholder="ex: Student Government Association (SGA)">
            </div>
            
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

<?php
    if(isset($_POST['search'])){
        $search = $_POST['search'];
        $Name = '%'.$search.'%';
        $search_string = htmlentities($search);

        $search_query = "SELECT * 
                FROM rso R
                WHERE R.Name like :name";

        $rso_params = array(':name' => $Name);
        $result = $db->prepare($search_query);
        $result->execute($rso_params);
        $number = $result->rowCount();
        
        echo "<h3><strong>$number result(s) found searching for '$search_string'. </strong></h3><hr><br>";

        while($row = $result->fetch()){
            $Name =$row['Name'];
            $ID = $row['RSO_id'];

            echo "<a href='/rso/profile?id=$ID'><h3><strong>$Name</strong></h3><hr></a>";
        }
    }
    
?>
<?php include TEMPLATE_BOTTOM; ?>