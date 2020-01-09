<?php
    session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>There are no dangerous thoughts; thinking itself is dangerous</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Days+One|Source+Sans+Pro|Roboto+Mono:400,700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/53f2cb228f.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body id="loginpage">
        <!--

            Hello, welcome!

            To reward your supremely high IQ, 
            here's a link to a hint:

            http://bit.ly/37IWstm

            I'm not responsible for what clicking on the 
            link will do to your computer.

            Or your soul.


             - Jae Wu



        -->

        <?php
        if (isset($_SESSION['user'])) {
            if($_SESSION['user'] === "admin") {
                echo '
    
                <div class="login-container">
                    <h1>Secure Login</h1>
                    <h2>INFILTRATION PORTAL</h2>
                    <h2>.. -. ... .--. . -.-. - . .-.. . -- . -. -</h2>
                    <form action="logout.inc.php">
                        <h2 style="padding-top:10px; line-height:25px;">You are already logged in as admin.<br><br></h2>
                        <a href="dais.php" style="padding-top:10px; line-height:25px;">Click here</a>
                        <input type="submit" value="Log Out">
                    </form>
                </div>';
            } else {
                echo '
    
                <div class="login-container">
                    <h1>Secure Login</h1>
                    <h2>INFILTRATION PORTAL</h2>
                    <h2>.. -. ... .--. . -.-. - . .-.. . -- . -. -</h2>
                    <form action="logout.inc.php">
                         <h2 style="padding-top:10px; line-height:25px;">You are already logged in as: ' . 
                         $_SESSION['user'] .
                        '<br><br></h2>
                        <a href="user.php" style="padding-top:10px; line-height:25px;">Click here</a>
                        <input type="submit" value="Log Out">
                    </form>
                </div>';
            }

        } else {
            echo <<<_
            <div class="login-container">
                <h1>Secure Login</h1>
                <h2>INFILTRATION PORTAL</h2>
                <h2>.. -. ... .--. . -.-. - . .-.. . -- . -. -</h2>
                <form action="login.inc.php" method="POST">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" value="Authorize Now" name="adhoc-login">
                </form>
            </div>
_;
        }

        ?>

        <div class="cool-decal-or-whatever">
            <img src="decal.png" alt="">
        </div>

    </body>
</html>