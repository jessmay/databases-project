<?php include '../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
    <title>Find Event</title>

<?php include TEMPLATE_MIDDLE; ?>

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

        $searchq = $_POST['search'];
        $sql = "SELECT * 
                FROM Event E
                WHERE E.Name like '%$searchq%'";

        $STH = $db->query($sql);
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $number = $STH->rowCount();
        echo "<h3><strong>$number result(s) found seaching for '$searchq'. </strong></h3><hr><br>";

        while($row = $STH->fetch()) {
            $Name =$row['Name'];
            echo "<h3><strong>$Name</strong></h3><hr>";
        }
    }
    
?>
<?php include TEMPLATE_BOTTOM; ?>