<?php

    session_start();

    require_once 'dbh.inc.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>
        <?php
            if(isset($_SESSION['user'])) {
                echo "&mdash;";
            } else {
                echo "ACCESS DENIED &mdash; PROTOCOL 01101100 01101001 01100111 01101101 01100001";
            }
         ?>
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Days+One|Source+Sans+Pro|Roboto+Mono:400,700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body id="daispage">
        <?php
            if($_SESSION['user']==="admin") {
                echo <<<_
                    <div class="dais-header">
                        <div class="logo">
                            <img src="http://pacificmun.org/logo-coloured-resize.png">
                            <div class="text">
                                <h1>DAIS CONTROL CENTRE</h1>
                                <h2>ADHOC Y</h2>
                            </div>
                        </div>
                        <div class="dais-help">
                            <a href="tel:778.245.3794"><i class="fa fa-info-circle"></i> Report an Issue</a>
                            <a href="logout.inc.php"><i class="fa fa-sign-out-alt"></i> Log Out</a>
                            <a href="dais.php"><i class="fas fa-redo"></i> Update</a>
                        </div>
                    </div>
                    <div class="dais-container">
                        <div class="left-col">
                            <div class="humanity">
                                <h4>Humanity Bloc Delegates</h4>
                                <div class="table-container">
                                <table>
                                    <tr>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">ID</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Name</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Delegate</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Missiles</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">M. Used</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Lives</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Charged?</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Login Pass</td>
                                    </tr>
_;
                                    require_once 'dbh.inc.php';

                                    $sql = "SELECT id, name, realname, missiles, missilesUsed, lives, isCharged, password FROM master WHERE team='Humanity'";
                                    $result = $conn->query($sql);
                                    
                                    if ($result-> num_rows > 0) {
                                        while ($row = $result-> fetch_assoc()) {
                                            $isCharged = "False";
                                            if($row['isCharged'] == 1) {
                                                $isCharged = "True";
                                                echo '<tr><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['realname'] . '</td><td>' . $row['missiles'] . '</td><td>' . $row['missilesUsed'] . '</td><td>' . $row['lives'] . '</td><td>' . $isCharged . '</td><td>' . $row['password'] . '</td></tr>';
                                            } else {
                                                echo '<tr><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['realname'] . '</td><td>' . $row['missiles'] . '</td><td>' . $row['missilesUsed'] . '</td><td>' . $row['lives'] . '</td><td>' . $isCharged . '</td><td>' . $row['password'] . '</td></tr>';
                                            }
                                        }
                                        echo '</table>';
                                    } else {
                                        echo 'Error -- Contact/Beatup Jae Wu via Call';
                                    }
echo<<<_
                                </table></div>
                            </div>
                            <div class="aliens">
                                <h4>Aliens Bloc Delegates</h4>
                                <table>
                                    <tr>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">ID</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Name</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Delegate</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Missiles</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">M. Used</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Lives</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Charged?</td>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Login Pass</td>
                                    </tr>
_;
                                    require_once 'dbh.inc.php';

                                    $sql = "SELECT id, name, realname, missiles, missilesUsed, lives, isCharged, password FROM master WHERE team='Alien'";
                                    $result = $conn->query($sql);
                                    
                                    if ($result-> num_rows > 0) {
                                        while ($row = $result-> fetch_assoc()) {
                                            if($row['isCharged'] == 1) {
                                                $isCharged = "True";
                                                echo '<tr><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['realname'] . '</td><td>' . $row['missiles'] . '</td><td>' . $row['missilesUsed'] . '</td><td>' . $row['lives'] . '</td><td>' . $isCharged . '</td><td>' . $row['password'] . '</td></tr>';
                                            } else {
                                                echo '<tr><td>' . $row['id'] . '</td><td>' . $row['name'] . '</td><td>' . $row['realname'] . '</td><td>' . $row['missiles'] . '</td><td>' . $row['missilesUsed'] . '</td><td>' . $row['lives'] . '</td><td>' . $isCharged . '</td><td>' . $row['password'] . '</td></tr>';
                                            }                                        
                                        }
                                        echo '</table>';
                                    } else {
                                        echo 'Error -- Contact/Beatup Jae Wu via Call';
                                    }
echo<<<_
                                </table>
                            </div>
                            <div class="utility">
                                <h4>Update Delegate Stats</h4>
                                <form action="update.inc.php" method="POST">
                                    <h5>Select Delegate</h5>
                                    <select name="delegate">
                                        <option value="Agent M">Agent M</option>
                                        <option value="Agent C">Agent C</option>
                                        <option value="Agent Y">Agent Y</option>
                                        <option value="Agent W">Agent W</option>
                                        <option value="Agent F">Agent F</option>
                                        <option value="Agent V">Agent V</option>
                                        <option value="Agent X">Agent X</option>
                                        <option value="Agent S">Agent S</option>
                                    </select>
                                    <h5>Stat to Update</h5>
                                    <select name="stat">
                                        <option value="missiles">Missiles</option>
                                        <option value="lives">Lives</option>
                                        <option value="ischarged">Powered Attack</option>
                                    </select>
                                    <h5>Value to Update To</h5>
                                    <input type="text" name="statvalue">
                                    <input type="submit" name="submitchange" value="Execute">
                                    <h5>*NOTE: Be careful, stats updated wrongly can really mess up the system :O There is no confirm button. <br><br>
                                    Also, to reward/take away from a delegate a powered attack, the value should be a "1" The value changes automatically 
                                    if they hit a powerup. Just in case you want to make their lives miserable.</h5>
                                </form>
                            </div>
                            <div class="utility">
                                <h4>Reset Game</h4>
                                <form action="reset.inc.php" method="POST">
                                    <h5>Please type "ADHOCYGAMERESET" to confirm:</h5>
                                    <input type="text" name="confirmtext" required>
                                    <input type="submit" name="resetconfirm" value="Reset Game">
                                    <h5>*DANGER: This action cannot be reversed. The game log will also be cleared. </h5>
                                </form>
                            </div>
                        </div>
                        <div class="right-col">
                            <div class="battleship">
                                <h4>Battleship Grid</h4>
                                
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

                            /* colours of cell depending on 
                                (1) POWERUP - (orange)
                                (2) HIT SHIP/POWERUP - (red)
                                (3) TEAM HUMANITY - (blue)
                                (4) TEAM ALIENS - (green)
                                (5) MISS FIRES - (aqua)
                            */
                            $hitcell = "#FF5050";
                            $humanity = "#0099FF";
                            $aliens = "#33CC33";
                            $powerup = "#FF9900";
                            $poweruphit = "darkmagenta";
                            $missfire = "#66CCFF";

                            // CELL CHECKS:
                            $aliencheck = "AL-";
                            $humanitycheck = "HU-";
                            $powercheck = "PU-";
                            $hitcheck = "TH-";

                            $alienmissfire = "-ALMF-";
                            $humanitymissfire = "-HUMF-";

                            
                            if ($result-> num_rows > 0) {
                                while ($row = $result-> fetch_assoc()) {
                                    $colArray = array($row['row'], $row['A'], $row['B'], $row['C'], $row['D'], $row['E'], $row['F'], $row['G'], $row['H'], $row['I'], $row['J']);
                                    echo '<tr>';
                                    foreach($colArray as $cell) {
                                        if ($cell === strval(1) || $cell === strval(2) || $cell === strval(3) || $cell === strval(4) || $cell === strval(5) || $cell === strval(6) || $cell === strval(7) || $cell === strval(8) || $cell === strval(9) || $cell === strval(10) || $cell === strval(11)) {
                                            echo "<td>" . $cell . "</td>";
                                        } else if(strpos($cell, $aliencheck) !== false) { // CHECK IF this coordinate belongs to team aliens
                                            if(strpos($cell, "F") !== false) {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $hitcell . "'>F</td>";
                                                } else {
                                                    echo "<td style='background:" . $aliens . "'>F</td>";
                                                }
                                            } else if(strpos($cell, "S") !== false) {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $hitcell . "'>S</td>";
                                                } else {
                                                    echo "<td style='background:" . $aliens . "'>S</td>";
                                                }
                                            } else if(strpos($cell, "X") !== false) {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $hitcell . "'>X</td>";
                                                } else {
                                                    echo "<td style='background:" . $aliens . "'>X</td>";
                                                }
                                            } else {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $hitcell . "'>V</td>";
                                                } else {
                                                    echo "<td style='background:" . $aliens . "'>V</td>";
                                                }
                                            }
                                        } else if(strpos($cell, $humanitycheck) !== false) { // CHECK IF this coordinate belongs to team humanity
                                            if(strpos($cell, "W") !== false) {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $hitcell . "'>W</td>";
                                                } else {
                                                    echo "<td style='background:" . $humanity . "'>W</td>";
                                                }
                                            } else if(strpos($cell, "M") !== false) {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $hitcell . "'>M</td>";
                                                } else {
                                                    echo "<td style='background:" . $humanity . "'>M</td>";
                                                }
                                            } else if(strpos($cell, "Y") !== false) {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $hitcell . "'>Y</td>";
                                                } else {
                                                    echo "<td style='background:" . $humanity . "'>Y</td>";
                                                }
                                            } else {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $hitcell . "'>C</td>";
                                                } else {
                                                    echo "<td style='background:" . $humanity . "'>C</td>";
                                                }
                                            }
                                        } else if(strpos($cell, $powercheck) !== false) { // CHECK IF this coordinate has a powerupif(strpos($cell, "M") !== false) {
                                            if(strpos($cell, "-GD") !== false) { 
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $poweruphit . "'>Golden Directive - Hit</td>";
                                                } else {
                                                    echo "<td style='background:" . $powerup . "'>Golden Directive</td>";
                                                }
                                            } else if(strpos($cell, "-SI") !== false) {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $poweruphit . "'>Silence - Hit</td>";
                                                } else {
                                                    echo "<td style='background:" . $powerup . "'>Silence</td>";
                                                }
                                            } else {
                                                if(strpos($cell, $hitcheck) !== false) { // CHECK IF hit
                                                    echo "<td style='background:" . $poweruphit . "'>Death Ray - Hit</td>";
                                                } else {
                                                    echo "<td style='background:" . $powerup . "'>Death Ray</td>";
                                                }
                                            }
                                        } else if(strpos($cell, $alienmissfire) !== false) { // CHECK IF Team Aliens missfired on this coordinate
                                            echo "<td style='background:" . $missfire . "'>Miss Fire</td>";
                                        } else if(strpos($cell, $humanitymissfire) !== false) { // CHECK IF Team Humanity missfired on this coordinate
                                            echo "<td style='background:" . $missfire . "'>Miss Fire</td>";
                                        } else {
                                            echo "<td style='background:var(--grey)'></td>";
                                        }
                                    }
                                    echo '</tr>';
                                } 
                            } else {
                                echo 'Error -- Contact/Beatup Jae Wu via Call';
                            }
echo<<<_
                        </table>
                            </div>
                            <div class="gamelog">
                                <h4>Activity Log</h4>
                                <table>
                                    <tr>
                                        <td style="font-weight:700; text-transform:uppercase; letter-spacing:0.4px;padding-top:10px;padding-bottom:10px;">Delegate Log | (WHEN: WHO WHAT)</td>
                                    </tr>
_;
                                    require_once 'dbh.inc.php';

                                    $sql = "SELECT log FROM master";
                                    $result = $conn->query($sql);
                                    
                                    if ($result-> num_rows > 0) {
                                        while ($row = $result-> fetch_assoc()) {
                                            if ($row['log'] !== "") {
                                                echo '<tr><td>' . $row['log'] . '</td>';   
                                            } else {
                                                echo "";
                                            }
                                        }
                                        echo '</table>';
                                    } else {
                                        echo 'Error -- Contact/Beatup Jae Wu via Call';
                                    }
echo<<<_
                                </table>
                            </div>
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
<!--
        <div class="cool-decal-or-whatever">
            <img src="decal.png" alt="">
        </div>

        Not too cool anymore...
-->

    </body>
</html>