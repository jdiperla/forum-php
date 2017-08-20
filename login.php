<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Forum Login</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script>
            $(document).ready(function()
            {
                $('#loginform').submit(function()
                {
                        $.ajax({
                            type: "POST",
                            url: "function/login.php",
                            data: $('#loginform').serialize(),
                            cache: false,
                            success: function(data){
                                if(data=="user")
                                {
                                   window.location.replace("index.php");
                                }
                                else if(data=="admin"){
                                    window.location.replace("index.php");
                                }
                                else {
                                    if(!$('#message').length){
                                        $('#error').prepend('<p id="message">Login failed! Please try again!</p>');
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
    <!--
    <c:if test="${param.error != null}">
            <p>Login failed.</p>
        </c:if>
        <c:if test="${param.logout != null}">
            <p>You have logged out.</p>
        </c:if> -->
    <?php
    if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        header("Location: ../index.php", true, 301);
        exit();
    }
    ?>
    <a href="index.php">Return to home page</a>
        <h2>Forum User Login</h2>
    <div id="error"></div>
        <form id="loginform" method="post">
            <label for="username">Username:</label><br/>
            <input type="text" id="username" name="username" required/><br/><br/>
            <label for="password">Password:</label><br/>
            <input type="password" id="password" name="password" required/><br/><br/>
            <input type="submit" value="Login"/>
        </form>
    </body>
</html>