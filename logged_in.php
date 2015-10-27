<div class="container col-xs-12">
    <h2>
        Welcome, <?=$_SESSION['user']['First_name']?>
    </h2>
    <hr>
    <div class="row">
        <div class="col-xs-6">
            <h3>
                <span class="glyphicon glyphicon-education" aria-hidden="true">
                </span>&nbsp;University
            </h3>
            <?php
                $university_query = '
                    SELECT N.Name, N.University_id
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
                echo '<a href="/university/profile?id=';
                echo $row['University_id'];
                echo '">';
                //echo ' ';
                echo $row['Name'].'</a>';
            ?>
        </div>
        <div class="col-xs-6">
            <h3>
                <span class="glyphicon glyphicon-blackboard" aria-hidden="true">
                </span>&nbsp;RSOs
            </h3>
            <?php
                $rso_query = '
                    SELECT R.Name, R.RSO_id
                    FROM RSO R, RSO_user H
                    WHERE R.RSO_id = H.RSO_id
                    AND H.User_id = :user_id
                ';
                $rso_params = array(
                    ':user_id' => $_SESSION['user']['User_id']
                );
                $result = $db->prepare($rso_query);
                $result->execute($rso_params);
                echo '<table class="table">';
                while ($row = $result->fetch()) {
                    echo '<tr><td><a href="/rso/profile?id='.$row['RSO_id'].'">';
                    echo $row['Name'].'</a></td></tr>';
                }
                echo '</table>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h3>
                <span class="glyphicon glyphicon-calendar" aria-hidden="true">
                </span>&nbsp;Calendar
            </h3>
            <?php
                $event_query = '
                    SELECT E.Name, E.Date_time, E.Event_id
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
                echo '<table class="table">';
                while ($row = $result->fetch()) {
                    echo '<tr><td><mark>';
                    echo date('F jS, Y (g a)', strtotime($row['Date_time']));
                    echo '</mark></td><td>';
                    echo '<a href="/event/view?id='.$row['Event_id'].'">';
                    echo $row['Name'].'</a>';
                    echo '</td></tr>'."\n";
                }
                echo '</table>';
            ?>
        </div>
    </div>
    <?php
    if ($is_type_super_admin):
    ?>
    <div class="row">
        <div class="col-xs-12">
            <h3>
                <span class="glyphicon glyphicon-check" aria-hidden="true">
                </span>&nbsp;Events to approve
            </h3>
            <script>
                $(function() {
                    $('button.approve-btn').click(function(e){
                        $(this).closest('tr').remove();
                        $.post("approve_event.php", {id : $(this).attr('event_id')});
                    });
                    $('button.delete-btn').click(function(e){
                        $(this).closest('tr').remove();
                        $.post("delete_event.php", {id : $(this).attr('event_id')});
                    });
                });
            </script>
            <?php
                $approval_query = '
                    SELECT E.Event_id, E.Name
                    FROM Event E, User U
                    WHERE E.Approved = 0
                    AND E.Admin_id = U.User_id
                    AND U.University_id = :university_id
                ';
                $result = $db->prepare($approval_query);
                $approval_params = array(
                    ':university_id' => $_SESSION['user']['University_id']
                );
                $result->execute($approval_params);
                echo '<table class="table">';
                if ($result->rowCount() === 0) {
                    echo '<span>You have no events to approve. <span class="glyphicon glyphicon-thumbs-up"></span></span>';
                }
                while ($row = $result->fetch()) {
                    echo '<tr><td>';
                    echo '<a href="/event/view?id='.$row['Event_id'].'">';
                    echo $row['Name'].'</a>';
                    echo '</td><td>';
                    ?>
                    <span class="btn-group btn-group-xs pull-right" role="group" aria-label="...">
                        <button type="button" class="btn btn-default approve-btn" event_id="<?=$row['Event_id']?>">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default delete-btn" event_id="<?=$row['Event_id']?>">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </span>
                    <?php
                    echo '</td></tr>';
                }
                echo '</table>';
            ?>
        </div>
    </div>
    <?php
    endif;
    ?>
</div>