<?php

    include_once 'dbh.inc.php';

    if(isset($_POST['submitchange'])) { // if coming from the dais page

        $delegate = $_POST['delegate'];
        $stat = $_POST['stat'];
        $statvalue = $_POST['statvalue'];

        $sql = "UPDATE master SET " . $stat . "='" . $statvalue . "' WHERE name='" . $delegate . "';";
        
        if(mysqli_query($conn, $sql)) {

            date_default_timezone_set('UTC');
            $hittimestamp = date('Y-m-d g:i:s A T');
            
            $sqllog = "INSERT INTO master(name, realname, team, missiles, missilesUsed, lives, isCharged, password, log) 
            VALUES ('NA', 'NA', 'NA', 0, 0, 0, 0, 'NA', '" . $hittimestamp . ": Dais set " . $stat . " of " . $delegate . " to " . $statvalue . "');";
            // log set up: "AGENT X attacked AGENT Y at time TIMESTAMP"
            if(mysqli_query($conn, $sqllog)) {

                // THE LIGHT AT THE END OF THE UNNECSESARIALY LOGN CONVVLOLUTED TUNNEL

                header('Location: dais.php?status=success');

            } else {
                header('Location: user.php?error=dberror-logging');
            }


        } else {
            header('Location: dais.php?status=error');
        }

    } else {
        header('Location: index.php');
    }

?>