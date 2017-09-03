<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Register</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
        @import url(http://fonts.googleapis.com/css?family=Oswald:400,300,700);
        .navbar{
            font-family:'Oswald';
        }
        .navbar-brand{
            font-size: 25px;
        }
        .navbar-nav{
            font-size: 16px;
        }
        #content{
            padding-left: 10px;
        }
        </style>
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
                                    $("#error").css("color", "red");
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
    <div class="container">
    <?php
    if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        header("Location: index.php", true, 301);
        exit();
    }
    ?>
         <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"><b>Study Forum</b></a>
    </div>
    <ul class="nav navbar-nav navbar-right">  
      <li><a href="login.php">Login</a></li>
      <li class="active"><a href="#">Register</a></li>
    </ul>
  </div>
</nav>
<div id="content">
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
        </div>
        </div>
    </body>
</html>
