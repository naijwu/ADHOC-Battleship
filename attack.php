<?php

    include_once 'dbh.inc.php';
    
    session_start();

    if(isset($_SESSION['user'])) { // if coming from the user page logged in
        if(isset($_POST['attack-submit'])) {  // if submitted form

            $delegate = $_SESSION['user'];
            $missilesUsed = 0;
            $missilesAvailable = 0;
            $lives = 0;
            $isCharged = 0;

            $x = strtoupper($_POST['x']);
            $y = strtoupper($_POST['y']);
            
            $sql = "SELECT team, missiles, missilesUsed, lives, isCharged FROM master WHERE name='" . $delegate . "';";
            $result = $conn->query($sql);
                                        
            if ($result-> num_rows > 0) {
                while ($row = $result-> fetch_assoc()) {
                    $missiles = $row['missiles'];

                    $missilesUsed = $row['missilesUsed'];
                    $lives = $row['lives'];
                    $isCharged = $row['isCharged'];

                    $team = "";

                    if($row['team'] === "Humanity") {
                        $team = "HU";
                    } else {
                        $team = "AL";
                    }

                    if ($lives > 0) {
                        // is not dead

                        if ($missiles > 0) {
                            // can attack

                            if ($isCharged) {
                                // is charged attack


                            } else {
                                // is not charged attack


                                $sqlgrid = "SELECT " . $x . " FROM grid WHERE row='" . $y . "';";
                                $resultgrid = $conn->query($sqlgrid);

                                $newdata = '';
                                                            
                                if ($resultgrid-> num_rows > 0) {
                                    while ($rowgrid = $resultgrid-> fetch_assoc()) {

                                        $sqldata = "SELECT " . $x . " FROM grid WHERE row='" . $y . "';";
                                        $resultdata = $conn->query($sqldata);
                                        $rowdata = $resultdata-> fetch_assoc();

                                        if((strpos($rowdata[$x], "AL-") !== false) || (strpos($rowdata[$x], "HU-") !== false)) {
                                            $newdata = $rowdata[$x] . "-" . $team . "TH-"; // target hit -- don't really care about friendly fire or double hits lmao
                                            
                                            $sqlcell = "UPDATE grid SET " . $x . "='" . $newdata . "' WHERE row='" . $y . "';";
                                            
                                            if(mysqli_query($conn, $sqlcell)) {
                                                // Update success on grid
                                                $newmissiles = $missiles - 1;
                                                $sqlcount = "UPDATE master SET missiles='" . $newmissiles. "' WHERE name='" . $delegate . "';";

                                                if(mysqli_query($conn, $sqlcount)) {
                                                    // missile used works
                                                    $newmissilecount = $missilesUsed + 1;
                                                    $sqlcount1 = "UPDATE master SET missilesUsed='" . $newmissilecount . "' WHERE name='" . $delegate . "';";

                                                    if(mysqli_query($conn, $sqlcount1)) {
                                                        header('Location: user.php?success=attackplotted');

                                                        // update console
                                                    } else {
                                                        header('Location: user.php?error=dberror-counting-used');
                                                    }
                                                } else {
                                                    // Counter Faulty
                                                    header('Location: user.php?error=dberror-counting-current');
                                                }

                                            } else {
                                                // Update faulty

                                                header('Location: user.php?error=dberror-hitting');
                                            }
                                            
                                            // echo $newdata . "would have been inputted to the database";
                                        } else {
                                            $newdata = $rowdata[$x] . "-" . $team . "MF-"; // missfired
                                            
                                            $sqlcell = "UPDATE grid SET " . $x . "='" . $newdata . "' WHERE row='" . $y . "';";
                                            
                                            if(mysqli_query($conn, $sqlcell)) {
                                                // Update success
                                                $newmissiles = $missiles - 1;
                                                $sqlcount = "UPDATE master SET missiles='" . $newmissiles . "' WHERE name='" . $delegate . "';";

                                                if(mysqli_query($conn, $sqlcount)) {
                                                    // missile used works
                                                    $newmissilecount = $missilesUsed + 1;
                                                    $sqlcount1 = "UPDATE master SET missilesUsed='" . $newmissilecount . "' WHERE name='" . $delegate . "';";

                                                    if(mysqli_query($conn, $sqlcount1)) {
                                                        header('Location: user.php?success=attackplotted');

                                                        // update console
                                                    } else {
                                                        header('Location: user.php?error=dberror-counting-used');
                                                    }
                                                } else {
                                                    // Counter Faulty
                                                    header('Location: user.php?error=dberror-counting');
                                                }

                                            } else {
                                                // Update faulty

                                                header('Location: user.php?error=dberror-hitting');
                                            }
                                        }

                                    }
                                } else {

                                    header('Location: user.php?error=dberror');

                                }

                            }
                        } else {
                            // can't attack, no missiles

                            header('Location: user.php?error=nomissiles');
                        }
                    } else {
                        // is dead

                        header('Location: user.php?error=dead');
                    }


                }
            } else {
                header('Location: user.php?error');
            }
            


            /*
            $sql = "UPDATE master SET " . $stat . "='" . $statvalue . "' WHERE name='" . $delegate . "';";
            
            if(mysqli_query($conn, $sql)) {
                header('Location: dais.php?status=success');
            } else {
                header('Location: dais.php?status=error');
            }
            */


        } else {
            header('Location: index.php');
        }
    } else {
        header('Location: user.php');
    }

?>