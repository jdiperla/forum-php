<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Forum Login</title>
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
    <div class="container">
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
     <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"><b>Study Forum</b></a>
    </div>
    <ul class="nav navbar-nav navbar-right">  
      <li class="active"><a href="#">Login</a></li>
      <li><a href="reg.php">Register</a></li>
    </ul>
  </div>
</nav>
<div id="content">
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
    </div>
    </div>
</html>