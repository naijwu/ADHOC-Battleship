<?php
    session_start();

    require_once 'dbh.inc.php';

    $sec = 10;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="refresh" content="<?php echo $sec?>;URL='user.php'">
        <title><?php
            if(isset($_SESSION['user'])) {
                echo "[" . $_SESSION['user'] . "] ADHOC Battle Control";
            } else {
                echo "ACCESS DENIED &mdash; PROTOCOL 01101100 01101001 01100111 01101101 01100001";
            }
         ?></title>
        <link href="https://fonts.googleapis.com/css?family=Days+One|Source+Sans+Pro&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php

            if(isset($_SESSION['user'])) {
                echo <<<_
                <div class="user-container">
                    <div class="dais-header">
                        <div class="logo">
                            <img src="http://pacificmun.org/logo-coloured-resize.png">
                            <div class="text">
_;
                        require_once 'dbh.inc.php';

                        $sql = 'SELECT * FROM master WHERE name="' . $_SESSION['user'] . '";';
                        $result = $conn->query($sql);

                        if ($result-> num_rows > 0) {
                            while ($row = $result-> fetch_assoc()) {

                                echo '<h1>' . $row['name'] . ' &mdash; Dashboard</h1>';
                                echo '<h2>Team ' . $row['team'] . '</h2>';
                            }
                        } else {
                            echo 'error &mdash;  :(';
                        }
                echo <<<_
                            </div>
                        </div>
                        <div class="dais-help">
                            <a href="tel:778.245.3794"><i class="fa fa-info-circle"></i> Report Issue</a>
                            <a href="logout.inc.php"><i class="fa fa-sign-out-alt"></i> Log Out</a>
                            <a href="user.php"><i class="fas fa-redo"></i> Update</a>
                        </div>
                    </div>
_;


                        $notif = $_GET['success'];
                        $error = $_GET['error'];

                        if(strpos($notif, "attackplotted") !== false) {

                            echo'
                            <div class="notification-box green">
                                <h3>Success: Attack Launched</h3>
                            </div>';
                        }

                        if(strpos($notif, "deathray") !== false) {

                            echo'
                            <div class="notification-box green">
                                <h3>Success: Attack Launched; Deathray Used</h3>
                            </div>';
                        }

                        if (strpos($error, "dberror") !== false) {

                            echo'
                            <div class="notification-box red">
                                <h3>Error: Input Error; Coordinate Out of Bounds?</h3>
                            </div>';
                        }

                    echo <<<_

                    <div class="stats-attack-container">
                    <div class="user-stats">
                        <h3>ADHOC INTERNATIONAL</h3>
                        <h4>STATS</h4>
                        <div class="stat-item">
                            <h5>NAME</h5>
_;
                            
                        $sql = 'SELECT * FROM master WHERE name="' . $_SESSION['user'] . '";';
                        $result = $conn->query($sql);

                            if ($result-> num_rows > 0) {
                                while ($row = $result-> fetch_assoc()) {

                                    echo '<h6 class="updateable">' . $row['name'] . '</h6>';
                                }
                            } else {
                                echo 'error &mdash;';
                            }

                echo <<<_
                        </div>
                        <div class="stat-item">
                            <h5>TEAM</h5>
_;
                        $sql = 'SELECT * FROM master WHERE name="' . $_SESSION['user'] . '";';
                        $result = $conn->query($sql);

                            if ($result-> num_rows > 0) {
                                while ($row = $result-> fetch_assoc()) {

                                    echo '<h6 class="updateable">' . $row['team'] . '</h6>';
                                }
                            } else {
                                echo 'error &mdash; ';
                            }
                echo <<<_
                        </div>
                        <div class="stat-item">
                            <h5>HEALTH</h5>
_;
                        $sql = 'SELECT * FROM master WHERE name="' . $_SESSION['user'] . '";';
                        $result = $conn->query($sql);

                            if ($result-> num_rows > 0) {
                                while ($row = $result-> fetch_assoc()) {

                                    if ($row['lives'] >= 0) {

                                        echo '<h6 class="updateable">' . $row['lives'] . '/3</h6>';
                                    } else {
                                        

                                        echo '<h6 class="updateable" style="background-color:rgb(145, 4, 4);">K.I.A.</h6>';
                                    }
                                }
                            } else {
                                echo 'error &mdash; ';
                            }

                echo <<<_
                        </div>
                        <div class="stat-item">
                            <h5>MISSILES</h5>
_;
                        $sql = 'SELECT * FROM master WHERE name="' . $_SESSION['user'] . '";';
                        $result = $conn->query($sql);

                            if ($result-> num_rows > 0) {
                                while ($row = $result-> fetch_assoc()) {

                                    echo '<h6 class="updateable">' . $row['missiles'] . '</h6>';
                                }
                            } else {
                                echo 'error &mdash; ';
                            }

                echo <<<_
                        </div>
                        <div class="stat-item">
                            <h5>POWER-UPS</h5>
_;
                        $sql = 'SELECT * FROM master WHERE name="' . $_SESSION['user'] . '";';
                        $result = $conn->query($sql);

                            if ($result-> num_rows > 0) {
                                while ($row = $result-> fetch_assoc()) {
                                    if($row['isCharged'] > 0) {
                                        echo '<h6 class="updateable">DEATH RAY (Area Attack)</h6>';
                                    } else {
                                        echo '<h6 class="updateable">NONE</h6>';
                                    }
                                }
                            } else {
                                echo 'error &mdash; ';
                            }
                echo <<<_
                        </div>
                    </div>
                    <div class="attack">
_;
                
                        $sql = 'SELECT missiles FROM master WHERE name="' . $_SESSION['user'] . '";';
                        $result = $conn->query($sql);

                            if ($result-> num_rows > 0) {
                                while ($row = $result-> fetch_assoc()) {
                                    if($row['missiles'] > 0) {
                                        echo <<<_
                                                <h3>Attack</h3>
                                                <h4>Plot Coordinates</h4>
                                                <form action="attack.php" method="POST" class="coordinates">
                                                    <div class="coordinates-container">
                                                        <div class="x-c">
                                                            <h5>X: </h5><input type="text" name="x">
                                                        </div>
                                                        <div class="y-c">
                                                            <h5>Y: </h5><input type="text" name="y">
                                                        </div>
                                                    </div>
                                                    <input type="submit" name="attack-submit" value="Attack">
                                                </form>
                                            </div>
_;
                                    } else {
                                        echo '
                                        <h3>Attack</h3>
                                        <h4>Plot Coordinates<br><br>&mdash;<br></h4>
                                        <h4 style="font-size:16px;">01101000 01100001 01101100 01100110 01110011 01100101 01101110 01100100 01100101 01110010 
                                        <br><br>
                                        No Available Missiles</h4>';
                                    }
                                }
                            } else {
                                echo 'error &mdash; ';
                            }

                    echo <<<_
                    </div>
                    </div>
                    <div class="grid">
                        <table>
                            <tr>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Row</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">A</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">B</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">C</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">D</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">E</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">F</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">G</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">H</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">I</td>
                                <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">J</td>
                            </tr>
_;
                            require_once 'dbh.inc.php';

                            $sql = "SELECT * FROM grid";
                            $result = $conn->query($sql);

                            /* grid syntax/identifiers for 
                                (1) MISS FIRE, -HUMF- or -ALMF-
                                (2) ENEMY HIT, -HUTH- or -ALTH-
                                (3) ALLY SHIPS, HU- or AL-
                                (4) AGENT'S SHIPS, -M-
                                (5) ALLY SHIP HIT, -ALTH- or -HUTH-
                            */
                            $agent = substr($_SESSION['user'], 6, 1);
                            $agentcheck = "-" . $agent . "-"; // e.g. '-M-'
                            $allies = "";
                            $axis = "";
                            
                            if ($agent == "W" || $agent == "Y" || $agent == "C" || $agent == "M") { // if agent belongs to team humanity
                                // could have found out team value by selecting from database, but trying to keep db queries to minimum 1
                                $allies = "HU"; // Humanity denoter
                                $axis = "AL"; // Aliens denoter
                            } else {
                                $allies = "AL";
                                $axis = "HU";
                            }

                            $missfirecheck = "-" . $allies . "MF-"; // Check if coordinate has been misfired on (by allies), e.g. '-HUMF-' (Humanity Team Misfired) (allied team always the Actor)
                            $vibecheck = "-" . $allies . "TH-"; // Check if coordinate has been hit on (by allies), e.g. '-HUTH-' (Humanity Team Hit Aliens)
                            $allycheck = $allies . "-"; // Check if ship on coordinate is an ally, e.g. 'HU-'
                            $allydamagedcheck = "-" . $axis . "TH-"; // Friendly Fire: On, checks if any ships are hit ($vibecheck) || OLD: Check if ship on coordinate is hit by other team, e.g. '-ALTH-'
                            $allyfriendlycheck = "-" . $allies . "TH-"; // friendly fire on

                            /* colours of cell depending on 
                                (1) ENEMY HIT (red), 
                                (2) MISS FIRE (blue), 
                                (3) ALLY SHIPS (green),
                                (4) ALLY SHIP HIT (orange),
                                (5) NOTHING, OCEAN, BLISS, LOL (aqua),
                                (6) POWERUP (gold)
                            */
                            $enemyhit = "#FF5050";
                            $missfire = "#0099FF";
                            $ally = "#33CC33";
                            $allyhit = "#FF9900";
                            $ocean = "#66CCFF";
                            $powerhit = "darkmagenta";

                            /*
                            echo "Ally check denoter: " . $allycheck . "<br>";
                            echo "Miss-fire check denoter: " . $missfirecheck . "<br>";
                            echo "Enemy hit check denoter: " . $vibecheck . "<br>";
                            echo "Ally Damaged check denoter: " . $allydamagedcheck;
                            */

                            
                            if ($result-> num_rows > 0) {
                                while ($row = $result-> fetch_assoc()) {
                                    $colArray = array($row['row'], $row['A'], $row['B'], $row['C'], $row['D'], $row['E'], $row['F'], $row['G'], $row['H'], $row['I'], $row['J']);
                                    echo '<tr>';
                                    foreach($colArray as $cell) {
                                        if(strpos($cell, $agentcheck) !== false) { // CHECK IF SHIP IS THEIR OWN

                                            if(strpos($cell, $allyfriendlycheck) !== false) { // CHECK IF DAMAGED
                                                echo "<td style='background:" . $allyhit . "'>" . $agent . " (You)</td>";
                                            } else if(strpos($cell, $allydamagedcheck) !== false) { // CHECK IF DAMAGED
                                                echo "<td style='background:" . $allyhit . "'>" . $agent . " (You)</td>";
                                            } else {
                                                // HEALTHY SHIP
                                                echo "<td style='background:" . $ally . "'>" . $agent . " (You)</td>";
                                            }
                                        } else if ($cell === strval(1) || $cell === strval(2) || $cell === strval(3) || $cell === strval(4) || $cell === strval(5) || $cell === strval(6) || $cell === strval(7) || $cell === strval(8) || $cell === strval(9) || $cell === strval(10) || $cell === strval(11)) {
                                            echo "<td>" . $cell . "</td>";
                                        } else {
                                            /*
                                                At this point, ship is not theirs. Thus, check following things:
                                                 - If ship is ally, show
                                                     - If ally ship has been hit by axis, show
                                                 - If ship has been hit by ally, show
                                                 - If there is a coordinate with a misfire, show
                                                 - If nothing, show ocean
                                            */
                                            if(strpos($cell, $allycheck) !== false) {
                                                /*
                                                    At this point, ship is ally. Thus, check following things:
                                                     - If ship is ally, show
                                                         - If ally ship has been hit by axis, show
                                                */

                                                if(strpos($cell, $allydamagedcheck) !== false) { // If ally ship has been hit by enemy
                                                    echo "<td style='background:" . $allyhit . "'>Ally Hit</td>";
                                                } else if(strpos($cell, $allyfriendlycheck) !== false) { // If ally ship has been hit by enemy
                                                    echo "<td style='background:" . $allyhit . "'>Ally Hit</td>";
                                                }/* else if(strpos($cell, $allycheck) !== false) {
                                                    echo "<td style='background:" . $ally . "'>Ally</td>";
                                                }*/ else {
                                                    echo "<td style='background:" . $ocean . "'></td>";
                                                }
                                            } else if(strpos($cell, $allydamagedcheck) !== false) {
                                                // enemy team friendly fired on themselves
                                                echo "<td style='background:" . $enemyhit . "'>Damaged</td>";
                                            } else {
                                                /*
                                                    At this point, ship is not ally:
                                                     - If ship has been hit by ally, show
                                                        - If ship = powerup, show
                                                     - If there is a coordinate with a misfire, show
                                                     - If neither, show ocean
                                                    
                                                */
                                                if(strpos($cell, $vibecheck) !== false) {
                                                    if(strpos($cell, "PU-SI-") !== false) {
                                                        // Silence Power up
                                                        echo "<td style='background:" . $powerhit . "'>Committee Powerup</td>";
                                                    } else if (strpos($cell, "PU-GD-") !== false) {
                                                        // Golden Directive Power up
                                                        echo "<td style='background:" . $powerhit . "'>Committee Powerup</td>";
                                                    } else if (strpos($cell, "PU-DR-") !== false) {
                                                        // Death Ray Power up
                                                        echo "<td style='background:" . $powerhit . "'>Death Ray</td>";
                                                    } else {
                                                        echo "<td style='background:" . $enemyhit . "'>Enemy Hit</td>";
                                                    }
                                                } else if(strpos($cell, $missfirecheck) !== false) {
                                                    echo "<td style='background:" . $missfire . "'>Miss-fire</td>";
                                                } else {
                                                    echo "<td style='background:" . $ocean . "'></td>";
                                                }
                                            }
                                        }
                                    }
                                    echo '</tr>';
                                } 
                            } else {
                                echo 'Error -- Contact/Beatup Jae Wu via Call';
                            }

                            //  echo '<tr><td>' . $row['row'] . '</td><td>' . $row['A'] . '</td><td>' . $row['B'] . '</td><td>' . $row['C'] . '</td><td>' . $row['D'] . '</td><td>' . $row['E'] . '</td><td>' . $row['F'] . '</td><td>' . $row['G'] . '</td><td>' . $row['H'] . '</td><td>' . $row['I'] . '</td><td>' . $row['J'] . '</td>';

echo<<<_
                        </table>
                    </div>
                </div>
_;
            } else {
                echo <<<_
                <div class="note">
                PACIFICMUN 2020 ADHOC<br>&mdash;<br>ACCESS DENIED<br>&mdash;<br>PROTOCOL 01101100 01101001 01100111 01101101 01100001<br>&mdash; <br><a href="index.php">OBTAIN AUTHORIZATION</a>
                </div>
_;
            }

        ?>

    </body>
</html>