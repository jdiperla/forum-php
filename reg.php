<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Register</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script>
            $(document).ready(function()
            {
                $('#regform').submit(function()
                {
                    $.ajax({
                        type: "POST",
                        url: "function/reg.php",
                        data: $('#regform').serialize(),
                        cache: false,
                        success: function(data){
                            if(data=="success")
                            {
                                window.location.replace("login.php");
                            }
                            else {
                                if(!$('#message').length){
                                    $('#error').prepend('<p id="message">Register failed! Please try again!</p>');
                                }
                            }
                        }
                    });
                    return false;
                });
            });
        </script>
    </head>
    <body>
    <?php
    if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        header("Location: ../index.php", true, 301);
        exit();
    }
    ?>
        <a href="index.php">Return to home page</a>
        <h2>Register</h2>
        <div id="error"></div>
        <form method="post" id="regform">
            <label for="username">Username:</label><br/>
            <input type="text" id="username" name="username" /><br/><br/>
            <label for="password">Password:</label><br/>
            <input type="password" id="password" name="password" /><br/><br/>
            <input type="hidden" name="roles" id="roles" value="ROLE_USER"/>
            <input type="submit" value="register" name="reg"/>
        </form>
    </body>
</html>
