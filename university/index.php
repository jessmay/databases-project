<?php include '../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
    <title>Find University</title>

<?php include TEMPLATE_MIDDLE; ?>

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
    if(isset($_POST['search'])){
        $search = $_POST['search'];
        $Name = '%'.$search.'%';
        $search_string = htmlentities($search);

        $search_query = "SELECT * 
                FROM University U
                WHERE U.Name like :name  AND U.University_id <> 1";

        $rso_params = array(':name' => $Name);
        $result = $db->prepare($search_query);
        $result->execute($rso_params);
        $number = $result->rowCount();
        
        echo "<h3><strong>$number result(s) found searching for '$search_string'. </strong></h3><hr><br>";

        while($row = $result->fetch()){
            $Name =$row['Name'];
            $ID = $row['University_id'];

            echo "<a href='/university/profile?id=$ID'><h3><strong>$Name</strong></h3><hr></a>";

        }
    }
    
?>

<?php include TEMPLATE_BOTTOM; ?>


