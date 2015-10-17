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

        $searchq = $_POST['search'];
        $sql = "SELECT * 
                FROM University U
                WHERE U.Name like '%$searchq%'";

        $STH = $db->query($sql);
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $number = $STH->rowCount();
        echo "<h3><strong>$number result(s) found seaching for '$searchq'. </strong></h3><br>";

        while($row = $STH->fetch()) {
            $Name =$row['Name'];
            echo "<h3><strong>$Name</strong></h3><hr>";
        }
    }
    
?>
<?php include TEMPLATE_BOTTOM; ?>


