<?php
include_once "configurations.php";
session_start();
if(isset($_SESSION['uid'])){
    header("Location: main.php");
    exit();
}
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/materialize.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script>
        $(document).ready(function(){
            $('.modal').modal();
            <?php
            if(isset($_SESSION['mhd'])){
            ?>
                $('#mainmodal').modal('open');
            <?php
            }
            ?>
        });
        </script>
    </head>
    <body class="grey darken-3">
        <div id="mainmodal" class="modal">
            <div class="modal-content">
                <h4><?php echo isset($_SESSION['mhd']) ? $_SESSION['mhd'] : ""; ?></h4>
                <p><?php echo isset($_SESSION['msg']) ? $_SESSION['msg'] : ""; ?></p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
            </div>
        </div>
        <form class="box card mainbox login" action="authen.php" method="post">
            <div class="input-field row">
                <input id="username" type="text">
                <label for="username">Username</label>
            </div>
            <div class="input-field row">
                <input id="password" type="password">
                <label for="password">Password</label>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <button class="fillh btn waves-effect waves-light" type="submit">Login</button>
                </div>
                <div class="input-field col s6">
                    <button class="fillh btn waves-effect waves-light" type="submit" name="regis" value="1">Register</button>
                </div>
            </div>
        </form>
    </body>
    <script src="js/materialize.min.js"></script>
</html>
