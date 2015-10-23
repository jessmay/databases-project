<div class="container col-xs-12">
    <h2>
        Welcome, <?=$_SESSION['user']['First_name']?>
    </h2>
    <hr>
    <div class="row">
        <div class="col-xs-6">
            <h3>Calendar</h3>
            <?php
                $event_query = '
                    SELECT E.Name, E.Date_time
                    FROM User U, Event_user R, Event E
                    WHERE U.User_id = :user_id
                    AND U.User_id = R.User_id 
                    AND R.Event_id = E.Event_id
                ';
                $event_params = array(
                    ':user_id' => $_SESSION['user']['User_id']
                );
                $result = $db->prepare($event_query);
                $result->execute($event_params);
                echo '<ul>';
                while ($row = $result->fetch()) {
                    echo '<li>'.date('F jS, Y (g a)', strtotime($row['Date_time'])).': '.$row['Name'].'</li>'."\n";
                }
                echo '</ul>'
            ?>
        </div>
        <div class="col-xs-6">
            <h3>University</h3>
            <?php
                $university_query = '
                    SELECT N.Name
                    FROM University N, User U
                    WHERE U.User_id = :user_id 
                    AND U.University_id = N.University_id
                ';
                $university_params = array(
                    ':user_id' => $_SESSION['user']['User_id']
                );
                $result = $db->prepare($university_query);
                $result->execute($university_params);
                $row = $result->fetch();
                echo '<span>'.$row['Name'].'</span>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <h3>RSOs</h3>
            <?php
                $rso_query = '
                    SELECT R.Name
                    FROM RSO R, RSO_user H
                    WHERE R.RSO_id = H.RSO_id
                    AND H.User_id = :user_id
                ';
                $rso_params = array(
                    ':user_id' => $_SESSION['user']['User_id']
                );
                $result = $db->prepare($rso_query);
                $result->execute($rso_params);
                $row = $result->fetch();
                echo '<span>'.$row['Name'].'</span>';
            ?>
        </div>
        <div class="col-xs-6">
            <h3>Events to approve</h3>
            <?php
                if ($is_type_super_admin) {
                    echo '<span>You are one smooth super admin.</span>';
                } else {
                    echo '<span>Do you think you\'re'.
                         ' some kind of super admin or what?</span>';
                }
            ?>
        </div>
    </div>
</div>