<?php

    include_once 'dbh.inc.php';

    if(isset($_POST['resetconfirm'])) { // if coming from the dais page

        if ($_POST['confirmtext'] === "ADHOCYGAMERESET") {

        $sql = "TRUNCATE TABLE grid;";
        
        if(mysqli_query($conn, $sql)) {

            
            $sql2 = "TRUNCATE TABLE master;";
            
            if(mysqli_query($conn, $sql2)) {
                

                $sql3 = "INSERT INTO grid (row, A, B, C, D, E, F, G, H, I, J) VALUES
                (1, 'A1', 'B1', 'C1', 'D1', 'E1', 'HU-W-T', 'G1', 'H1', 'I1', 'J1'),
                (2, 'AL-F-L', 'AL-F-C', 'AL-F-R', 'D2', 'E2', 'HU-W-C', 'G2', 'HU-Y-L', 'HU-Y-C', 'HU-Y-R'),
                (3, 'A3', 'B3', 'C3', 'AL-V-T', 'E3', 'HU-W-B', 'G3', 'PU-SI-1', 'I3', 'J3'),
                (4, 'A4', 'B4', 'AL-V-L', 'AL-V-B', 'E4', 'F4', 'G4', 'H4', 'I4', 'AL-S-T'),
                (5, 'A5', 'B5', 'C5', 'D5', 'PU-GD-1', 'F5', 'G5', 'H5', 'AL-S-L', 'AL-S-B'),
                (6, 'PU-GD-2', 'B6', 'HU-C-L', 'HU-C-T', 'E6', 'F6', 'G6', 'H6', 'PU-DR-1', 'J6'),
                (7, 'A7', 'B7', 'C7', 'HU-C-B', 'E7', 'F7', 'G7', 'AL-X-T', 'I7', 'J7'),
                (8, 'A8', 'B8', 'C8', 'D8', 'PU-SI-2', 'F8', 'G8', 'AL-X-C', 'I8', 'J8'),
                (9, 'A9', 'B9', 'C9', 'D9', 'E9', 'F9', 'G9', 'AL-X-B', 'I9', 'PU-DR-2'),
                (10, 'A10', 'B10', 'C10', 'HU-M-L', 'HU-M-C', 'HU-M-R', 'G10', 'H10', 'I10', 'J10');";
            
                if(mysqli_query($conn, $sql3)) {
                    
                    $sql4 = "INSERT INTO master (id, name, realname, team, missiles, missilesUsed, lives, isCharged, password, log) VALUES
                    (1, 'Agent M', 'Ray Oh', 'Humanity', 0, 0, 3, 0, 'Z69DX', ''),
                    (2, 'Agent C', 'Marisa Smith', 'Humanity', 0, 0, 3, 0, '3UZM6', ''),
                    (3, 'Agent Y', 'Owen Ebose', 'Humanity', 0, 0, 3, 0, 'A4228', ''),
                    (4, 'Agent W', 'Cynthia Gan', 'Humanity', 0, 0, 3, 0, 'W98L6', ''),
                    (5, 'Agent F', 'Su Ann Ho', 'Alien', 0, 0, 3, 0, 'VZ050', ''),
                    (6, 'Agent V', 'Josh Harris', 'Alien', 0, 0, 3, 0, 'G91V5', ''),
                    (7, 'Agent X', 'Armon Kaboly', 'Alien', 0, 0, 3, 0, 'X02YY', ''),
                    (8, 'Agent S', 'Nikolas Michael', 'Alien', 0, 0, 3, 0, '9HU6W', '');";
                    
                    if(mysqli_query($conn, $sql4)) {

                        date_default_timezone_set('UTC');
                        $hittimestamp = date('Y-m-d g:i:s A T');
                        
                        $sqllog = "INSERT INTO master(name, realname, team, missiles, missilesUsed, lives, isCharged, password, log) 
                        VALUES ('NA', 'NA', 'NA', 0, 0, 0, 0, 'NA', '" . $hittimestamp . ": Game has been reset');";
                        // log set up: "AGENT X attacked AGENT Y at time TIMESTAMP"
                        if(mysqli_query($conn, $sqllog)) {

                            // THE LIGHT AT THE END OF THE UNNECSESARIALY LOGN CONVVLOLUTED TUNNEL

                            header('Location: dais.php?status=reset');

                        } else {
                            header('Location: user.php?error=dberror-logging');
                        }
                        
                    } else {
                        header('Location: dais.php?status=masterinsert');
                    }

                    
                } else {
                    header('Location: dais.php?status=gridinsert');
                }


            } else {
                header('Location: dais.php?status=mastertrunicate');
            }


        } else {
            header('Location: dais.php?status=gridtrunicate');
        }
        
        } else {
            header('Location: dais.php?error=noconfirm');
        }

    } else {
        header('Location: index.php');
    }

?>