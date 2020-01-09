<?php
    if(isset($_POST['adhoc-login'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

                if($username === "DAISTEAMUSERNAME") {
                    if($password === "password") {
                        session_start();
                        $_SESSION['user'] = "admin";
                        header('Location: dais.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentm") {
                    if($password === "agentm") {
                        session_start();
                        $_SESSION['user'] = "Agent M";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentc") {
                    if($password === "agentc") {
                        session_start();
                        $_SESSION['user'] = "Agent C";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agenty") {
                    if($password === "agenty") {
                        session_start();
                        $_SESSION['user'] = "Agent Y";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentw") {
                    if($password === "agentw") {
                        session_start();
                        $_SESSION['user'] = "Agent W";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentf") {
                    if($password === "agentf") {
                        session_start();
                        $_SESSION['user'] = "Agent F";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentv") {
                    if($password === "agentv") {
                        session_start();
                        $_SESSION['user'] = "Agent V";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agentx") {
                    if($password === "agentx") {
                        session_start();
                        $_SESSION['user'] = "Agent X";
                        header('Location: user.php?status=loginSuccess');
                        exit();
                    } else {
                        header('Location: index.php?status=wrongCredentialsIMightJustRickRoll');
                        exit();
                    }
                } else if($username === "agents") {
                    if($password === "agents") {
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
