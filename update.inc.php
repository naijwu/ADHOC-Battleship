<?php

    include_once 'dbh.inc.php';

    if(isset($_POST['submitchange'])) { // if coming from the dais page

        $delegate = $_POST['delegate'];
        $stat = $_POST['stat'];
        $statvalue = $_POST['statvalue'];

        $sql = "UPDATE master SET " . $stat . "='" . $statvalue . "' WHERE name='" . $delegate . "';";
        
        if(mysqli_query($conn, $sql)) {
            header('Location: dais.php?status=success');
        } else {
            header('Location: dais.php?status=error');
        }

    } else {
        header('Location: index.php');
    }

?>