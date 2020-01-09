<?php
    if(isset($_POST['adhoc-login'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

                if($username === "bestdaisteam") {
                    if($password === "password123") {
                        session_start();
                        $_SESSION['user'] = "admin";
                        header('Location: dais.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentm") {
                    if($password === "Z69DX") {
                        session_start();
                        $_SESSION['user'] = "Agent M";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentc") {
                    if($password === "3UZM6") {
                        session_start();
                        $_SESSION['user'] = "Agent C";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agenty") {
                    if($password === "A4228") {
                        session_start();
                        $_SESSION['user'] = "Agent Y";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentw") {
                    if($password === "W98L6") {
                        session_start();
                        $_SESSION['user'] = "Agent W";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentf") {
                    if($password === "VZ050") {
                        session_start();
                        $_SESSION['user'] = "Agent F";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentv") {
                    if($password === "G91V5") {
                        session_start();
                        $_SESSION['user'] = "Agent V";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentx") {
                    if($password === "X02YY") {
                        session_start();
                        $_SESSION['user'] = "Agent X";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agents") {
                    if($password === "9HU6W") {
                        session_start();
                        $_SESSION['user'] = "Agent S";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else {
                    header('Location: index.php?status=urabouttogetrickrolledbruh');
                    exit();
                }

    } else {
        header('Location: index.php?youbrokethesystem');
        exit();
    }
?>