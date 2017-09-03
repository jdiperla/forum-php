<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Study Forum</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            @import url(http://fonts.googleapis.com/css?family=Oswald:400,300,700);
            h1 {
               
                padding-left: 10px;
            }
            h3 {
                padding-left: 30px;
            }
            .list ul li{
                margin-bottom:10px;
            }
            .list{ 
                margin-left: -20px;
                width: 300px;
            }
            .navbar{
                font-family:'Oswald';
            }
            .navbar-brand{
                font-size: 25px;
            }
            .navbar-nav{
                font-size: 16px;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <?php
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            ?>          
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" href="index.php"><b>Study Forum</b></a>
    </div>
    <ul class="nav navbar-nav">
      <li><p class="navbar-text">Hello <?= $_SESSION['username'] ?></p></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php">Logout</a></li>
      <li><a href="changepassword.php">Change password</a></li>
    </ul>
    
  </div>
</nav>
        
          
            <?php
        } else {
            ?>
            <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" href="index.php"><b>Study Forum</b></a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="login.php">Login</a> </li>
      <li><a href="reg.php">Register</a></li>
    </ul>
  </div>
</nav>
    
            <?php
        }
        ?>
        <div id="content">
            <h1>Welcome to Study Forum</h1>
            <div class="list">
                <nav>
                    <h3>Category List</h3>
                    <ul>
                        <li><a href="category.php?type=Lecture">Lecture</a></li>
                        <li><a href="category.php?type=Lab">Lab</a></li>
                        <li><a href="category.php?type=Other">Other</a></li>
                    </ul>
                </nav>
            </div>
            </div>
        </div>
    </body>
</html>