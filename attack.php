<?php

    include_once 'dbh.inc.php';
    
    session_start();

    if(isset($_SESSION['user'])) { // if coming from the user page logged in
        if(isset($_POST['attack-submit'])) {  // if submitted form

            /*
                When a delegate attacks: different outcomes > diff changes based on outcomes (duh)

                Shared changes across all outcomes: (but I'm not going to be using function because for some (irrational) reason I
                think functions in php are going to fail by timing out if I send a lot of requests to the mysql... it's like 
                social anxiety all over again except not social... what does that make me? a FIXED HUMAN BEING?)
                 1. minus missile count (masters table)
                 2. plus missiles used count (masters table)
                 3. update grid (grid table)
                 4. update log (masters table)
                

                 - miss fires > no unique changes
                 - hits enemy or friendly > lives minus for target hit
                 - hits viable powerup > (conditional: if Death Ray hit) add powerup to delegate, (2) powerup becomes 'used' 
                        (specific update on grid)

                 - uses deathray : 
                    - multiple previous outcomes -- (note before programming: i think this might be a big headache)
            */

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

                                /*
                                    Flow:
                                     - Set isCharged to 0
                                     - Log a deathray (return "TIME: AGENT X deployed)
                                     - Find coordinates of the 5 different attack points
                                            (Create an array of the Rows and Columns, and traverse from there)
                                     - Loop through each attack point
                                        - Check if it's a viable attack point
                                            - Trigger function attack for all viable attack points
                                                    (function attack is essentially all the code down below, w/out header)
                                            - If not viable, loop previously
                                */

                                $xarray = array(
                                    1 => "A",
                                    2 => "B",
                                    3 => "C",
                                    4 => "D",
                                    5 => "E",
                                    6 => "F",
                                    7 => "G",
                                    8 => "H",
                                    9 => "I",
                                    10 => "J"
                                );

                                $yarray = array(
                                    1 => "1",
                                    2 => "2",
                                    3 => "3",
                                    4 => "4",
                                    5 => "5",
                                    6 => "6",
                                    7 => "7",
                                    8 => "8",
                                    9 => "9",
                                    10 => "10"
                                );

                                // Map X Y coordinates of battleship grid to arrays to traverse, in order to check if out of bounds

                                $indexOfX = 0;
                                $indexOfY = 0;

                                foreach($xarray as $key => $value) {
                                    if ($value === $x) {
                                        $indexOfX = $key;
                                    }
                                }

                                unset($key);
                                unset($value);
                                
                                foreach($yarray as $key => $value) {
                                    if ($value === $y) {
                                        $indexOfY = $key;
                                    }
                                }

                                unset($key);
                                unset($value);

                                // check potential firing areas individually by evaluating worst-case... not in a box because you should still fire, just without the ones that don't work
                                
                                // assumes all spots don't work
                                $deathRayTargets = array(
                                    "Top Left" => 0,
                                    "Top Right" => 0,
                                    "Bottom Left" => 0,
                                    "Bottom Right" => 0,
                                    "Centre" => 1
                                );

                                // Top Left Validity
                                if ( (($indexOfX - 1) > 0) and (($indexOfY - 1) > 0) ) {
                                    $deathRayTargets['Top Left'] = 1;
                                }

                                // Top Right Validity
                                if ( (($indexOfX + 1) < 11) and (($indexOfY - 1) > 0) ) {
                                    $deathRayTargets['Top Right'] = 1;
                                }

                                // Bottom Left Validity
                                if ( (($indexOfX - 1) > 0) and (($indexOfY + 1) < 11) ) {
                                    $deathRayTargets['Bottom Left'] = 1;
                                }

                                // Bottom Right Validity
                                if ( (($indexOfX + 1) < 11) and (($indexOfY + 1) < 11) ) {
                                    $deathRayTargets['Bottom Right'] = 1;
                                }


                                // go through prelim stuff necessary
                                $sqlcharge = "UPDATE master SET isCharged='0' WHERE name='" . $delegate . "';";
                                if(mysqli_query($conn, $sqlcharge)) {
                                    
                                    // Update success on grid
                                    $newmissiles = $missiles - 1;
                                    $sqlcount = "UPDATE master SET missiles='" . $newmissiles. "' WHERE name='" . $delegate . "';";

                                    if(mysqli_query($conn, $sqlcount)) {
                                        // missile used works
                                        $newmissilecount = $missilesUsed + 1;
                                        $sqlcount1 = "UPDATE master SET missilesUsed='" . $newmissilecount . "' WHERE name='" . $delegate . "';";

                                        if(mysqli_query($conn, $sqlcount1)) {

                                            date_default_timezone_set('UTC');
                                            $hittimestamp = date('Y-m-d g:i:s A T');
                                            
                                            // update console
                                            $sqllog = "INSERT INTO master(name, realname, team, missiles, missilesUsed, lives, isCharged, password, log) 
                                            VALUES ('NA', 'NA', 'NA', 0, 0, 0, 0, 'NA', '" . $hittimestamp . ": " . $delegate . " used DEATHRAY at (" . $x . ", " . $y . ")');";
                                            // log set up: "AGENT X attacked AGENT Y at time TIMESTAMP"
                                            if(mysqli_query($conn, $sqllog)) {
                                        
        
                                                // loop through and attacc
                                                
                                                foreach($deathRayTargets as $key => $value) {
                
                                                    // note on function being called: attackCoord(delegate(str), missilesUsed(int), missiles(int), attackx(char), attacky(int), $conn) 
                                                    
                                                    if ( ($key === "Centre") && ($value === 1) ) {
                                                        attackCoord($delegate, $team, $missilesUsed, $missiles, $xarray[$indexOfX], $yarray[$indexOfY], $conn);
                                                    }
        
                                                    if ( ($key === "Top Left") && ($value === 1) ) {
                                                        attackCoord($delegate, $team, $missilesUsed, $missiles, $xarray[$indexOfX-1], $yarray[$indexOfY-1], $conn);
                                                    }
        
                                                    if ( ($key === "Top Right") && ($value === 1) ) {
                                                        attackCoord($delegate, $team, $missilesUsed, $missiles, $xarray[$indexOfX+1], $yarray[$indexOfY-1], $conn);
                                                    }
        
                                                    if ( ($key === "Bottom Left") && ($value === 1) ) {
                                                        attackCoord($delegate, $team, $missilesUsed, $missiles, $xarray[$indexOfX-1], $yarray[$indexOfY+1], $conn);
                                                    }
        
                                                    if ( ($key === "Bottom Right") && ($value === 1) ) {
                                                        attackCoord($delegate, $team, $missilesUsed, $missiles, $xarray[$indexOfX+1], $yarray[$indexOfY+1], $conn);
                                                    }
                                                }
        
                                                header('Location: user.php?success=deathray');
        
                                            } else {
                                                header('Location: user.php?error=dberror-logging');
                                            }
                                            
                                        }
                                    }
                                    

                                } else {
                                    header('Location: user.php?error=dberror');
                                }

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
                                            
                                            /*
                                            echo $newdata . "<br>";
                                            echo $rowdata[$x] . "<br>";
                                            echo substr($rowdata[$x], 3, 1);
                                            exit();
                                            */

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
                                                        // minus life of delegate hit
                                                        $agenthit = "Agent " . substr($rowdata[$x], 3, 1);

                                                        $sqllives = "SELECT lives FROM master WHERE name='" . $agenthit . "';";
                                                        $resultlives = $conn->query($sqllives);
                                                        
                                                        if ($resultlives-> num_rows > 0) {
                                                            while ($rowlives = $resultlives-> fetch_assoc()) {
                                                                $newlives = $rowlives['lives'] - 1;

                                                                $sqllives1 = "UPDATE master SET lives='" . $newlives . "' WHERE name='" . $agenthit . "';";

                                                                if(mysqli_query($conn, $sqllives1)) {

                                                                    date_default_timezone_set('UTC');

                                                                    $hittimestamp = date('Y-m-d g:i:s A T');
                                                                    
                                                                    // update console
                                                                    $sqllog = "INSERT INTO master(name, realname, team, missiles, missilesUsed, lives, isCharged, password, log) 
                                                                    VALUES ('NA', 'NA', 'NA', 0, 0, 0, 0, 'NA', '" . $hittimestamp . ": " . $delegate . " attacked " . $agenthit . " at (" . $x . ", " . $y . ")');";
                                                                    // log set up: "AGENT X attacked AGENT Y at time TIMESTAMP"
                                                                    if(mysqli_query($conn, $sqllog)) {

                                                                        // THE LIGHT AT THE END OF THE UNNECSESARIALY LOGN CONVVLOLUTED TUNNEL

                                                                        header('Location: user.php?success=attackplotted');

                                                                    } else {
                                                                        header('Location: user.php?error=dberror-logging');
                                                                    }

                                                                } else {
                                                                    header('Location: user.php?error=dberror-lives-update');
                                                                }
                                                            }
                                                        } else {
                                                            header('Location: user.php?error=dberror-lives-select');
                                                        }
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
                                        } else if((strpos($rowdata[$x], "PU-") !== false) && (strpos($rowdata[$x], "TH-") === false)) {
                                            // if hit powerup, and powerup hasn't been previously hit

                                            /*
                                                From here:
                                                 - missile used up 1
                                                 - missile available down 1
                                                 - IF DEATHRAY, acquire powerup
                                                 - update on log

                                            */
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

                                                        date_default_timezone_set('UTC');
                                                        $hittimestamp = date('Y-m-d g:i:s A T');

                                                        $hitpowerup="";

                                                        if (strpos($rowdata[$x], "PU-SI-") !== false) {
                                                            $hitpowerup = "Silence";
                                                        } else if (strpos($rowdata[$x], "PU-GD-") !== false) {
                                                            $hitpowerup = "Golden Directive";
                                                        }

                                                        if(strpos($rowdata[$x], "PU-DR-") !== false) {

                                                            $sqlacquire = "UPDATE master SET isCharged=1 WHERE name='".$delegate . "'";
                                                            
                                                            if(mysqli_query($conn, $sqlacquire)) {
        
                                                                // update console
                                                                $sqllog = "INSERT INTO master(name, realname, team, missiles, missilesUsed, lives, isCharged, password, log) 
                                                                VALUES ('NA', 'NA', 'NA', 0, 0, 0, 0, 'NA', '" . $hittimestamp . ": " . $delegate . " acquired DEATH RAY at (" . $x . ", " . $y . ")');";
                                                                // log set up: "AGENT X acquire POWERUP Y at time TIMESTAMP"
                                                                if(mysqli_query($conn, $sqllog)) {
        
                                                                    // THE LIGHT AT THE END OF THE UNNECSESARIALY LOGN CONVVLOLUTED TUNNEL
        
                                                                    header('Location: user.php?success=attackplotted');
        
                                                                } else {
                                                                    header('Location: user.php?error=dberror-logging');
                                                                }
                                                            } else {
                                                                header('Location: user.php?error=dberror-changepowerup');
                                                                exit();
                                                            }

                                                        } else {
    
                                                            // update console
                                                            $sqllog = "INSERT INTO master(name, realname, team, missiles, missilesUsed, lives, isCharged, password, log) 
                                                            VALUES ('NA', 'NA', 'NA', 0, 0, 0, 0, 'NA', '" . $hittimestamp . ": " . $delegate . " acquired " . $hitpowerup . "');";
                                                            // log set up: "AGENT X acquire POWERUP Y at time TIMESTAMP"
                                                            if(mysqli_query($conn, $sqllog)) {
    
                                                                // THE LIGHT AT THE END OF THE UNNECSESARIALY LOGN CONVVLOLUTED TUNNEL
    
                                                                header('Location: user.php?success=attackplotted');
    
                                                            } else {
                                                                header('Location: user.php?error=dberror-logging');
                                                            }
                                                        }
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

                                                        date_default_timezone_set('UTC');

                                                        $hittimestamp = date('Y-m-d g:i:s A T');
                                                        
                                                        // update console
                                                        $sqllog = "INSERT INTO master(name, realname, team, missiles, missilesUsed, lives, isCharged, password, log) 
                                                        VALUES ('NA', 'NA', 'NA', 0, 0, 0, 0, 'NA', '" . $hittimestamp . ": " . $delegate . " missed at (" . $x . ", " . $y . ")');";
                                                        // log set up: "AGENT X attacked AGENT Y at time TIMESTAMP"
                                                        if(mysqli_query($conn, $sqllog)) {

                                                            // THE LIGHT AT THE END OF THE UNNECSESARIALY LOGN CONVVLOLUTED TUNNEL

                                                            header('Location: user.php?success=attackplotted');

                                                        } else {
                                                            header('Location: user.php?error=dberror-logging');
                                                        }
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

    function attackCoord($delegate, $team, $missilesUsed, $missiles, $x, $y, $conn) {

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
                    
                    /*
                    echo $newdata . "<br>";
                    echo $rowdata[$x] . "<br>";
                    echo substr($rowdata[$x], 3, 1);
                    exit();
                    */

                    $sqlcell = "UPDATE grid SET " . $x . "='" . $newdata . "' WHERE row='" . $y . "';";
                    
                    if(mysqli_query($conn, $sqlcell)) {
                        // minus life of delegate hit
                        $agenthit = "Agent " . substr($rowdata[$x], 3, 1);

                        $sqllives = "SELECT lives FROM master WHERE name='" . $agenthit . "';";
                        $resultlives = $conn->query($sqllives);
                        
                        if ($resultlives-> num_rows > 0) {
                            while ($rowlives = $resultlives-> fetch_assoc()) {
                                $newlives = $rowlives['lives'] - 1;

                                $sqllives1 = "UPDATE master SET lives='" . $newlives . "' WHERE name='" . $agenthit . "';";

                                if(mysqli_query($conn, $sqllives1)) {
                                    return;

                                } else {
                                    header('Location: user.php?error=dberror-lives-update');
                                }
                            }
                        } else {
                            header('Location: user.php?error=dberror-lives-select');
                        }

                    } else {
                        // Update faulty

                        header('Location: user.php?error=dberror-hitting');
                    }
                    
                    // echo $newdata . "would have been inputted to the database";
                } else if((strpos($rowdata[$x], "PU-") !== false) && (strpos($rowdata[$x], "TH-") === false)) {
                    // if hit powerup, and powerup hasn't been previously hit

                    $newdata = $rowdata[$x] . "-" . $team . "TH-"; // target hit -- don't really care about friendly fire or double hits lmao
                    
                    $sqlcell = "UPDATE grid SET " . $x . "='" . $newdata . "' WHERE row='" . $y . "';";
                    
                    if(mysqli_query($conn, $sqlcell)) {
                        $hitpowerup="";

                        if (strpos($rowdata[$x], "PU-SI-") !== false) {
                            $hitpowerup = "Silence";
                        } else if (strpos($rowdata[$x], "PU-GD-") !== false) {
                            $hitpowerup = "Golden Directive";
                        }

                        if(strpos($rowdata[$x], "PU-DR-") !== false) {

                            $sqlacquire = "UPDATE master SET isCharged=1 WHERE name='".$delegate . "'";
                            
                            if(mysqli_query($conn, $sqlacquire)) {

                                return;
                            } else {
                                header('Location: user.php?error=dberror-changepowerup');
                                exit();
                            }

                        } else {
                            return;
                        }

                    } else {
                        // Update faulty

                        header('Location: user.php?error=dberror-hitting');
                    }

                } else {
                    $newdata = $rowdata[$x] . "-" . $team . "MF-"; // missfired
                    
                    $sqlcell = "UPDATE grid SET " . $x . "='" . $newdata . "' WHERE row='" . $y . "';";
                    
                    if(mysqli_query($conn, $sqlcell)) {
                        return;

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

?>