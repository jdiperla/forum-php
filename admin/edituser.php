<!DOCTYPE html>
<?php
session_start();
require_once('../class/Database.php');
require_once('../class/User.php');

$database = new Database();
$db = $database->DbConnection();
$user = new User($db);
$username = $_GET['name'];
$user->setUsername($username);
$sql = "SELECT user.username ,user.password ,GROUP_CONCAT(user_roles.role SEPARATOR ' ') as role FROM user,user_roles WHERE user.username=user_roles.username and user.username=:username GROUP BY user.username";
$stmt = $user->selectUser($sql);
?>
<html>
<head>
    <title>Edit User</title>
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
            $('#editform').submit(function()
            {
                $.ajax({
                    type: "POST",
                    url: "function/edit.php",
                    data: $('#editform').serialize(),
                    cache: false,
                    success: function(data){
                        if(data=="success")
                        {
                            window.location.replace("index.php");
                        }
                        else {
                            alert(data);
                            /*if(!$('#message').length){
                                $('#error').prepend('<p id="message">Edit failed! Please try again!</p>');
                            }*/
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
if(isset($_SESSION['username']) && !empty($_SESSION['username']) && $_SESSION['role']=="admin") {
    ?>
     <nav class="navbar navbar-default">
     <div class="container-fluid">
       <div class="navbar-header">
       <a class="navbar-brand" href="../index.php"><b>Study Forum</b></a>
       </div>
       <ul class="nav navbar-nav">
         <li><p class="navbar-text">Hello <?= $_SESSION['username'] ?></p></li>
       </ul>
       <ul class="nav navbar-nav navbar-right">
         <li><a href="index.php">Return to Admin Page</a></li>
         <li><a href="logout.php">Logout</a></li>
         <li><a href="changepassword.php">Change password</a></li>
       </ul>
       
     </div>
   </nav>
    <?php
}
else{
    header("Location: ../index.php", true, 301);
    exit();
    ?>
    <?php
}
?>
<div id="content">
<h2>Edit a User</h2>
<div id="error"></div>
<?php
if ($stmt && $stmt->rowCount() > 0){
$row = $stmt->fetchAll();
$role = explode(" ", $row[0]['role']);
if (in_array("ROLE_USER", $role)) {
   $inputuser="<input type=\"checkbox\" id=\"user\" name=\"role[]\" value=\"ROLE_USER\" checked>ROLE_USER";
}
else{
    $inputuser="<input type=\"checkbox\" id=\"user\" name=\"role[]\" value=\"ROLE_USER\">ROLE_USER";
}
if (in_array("ROLE_ADMIN", $role)) {
    $inputadmin="<input type=\"checkbox\" id=\"admin\" name=\"role[]\" value=\"ROLE_ADMIN\" checked>ROLE_ADMIN<br/><br/>";
}
else{
    $inputadmin="<input type=\"checkbox\" id=\"admin\" name=\"role[]\" value=\"ROLE_ADMIN\">ROLE_ADMIN<br/><br/>";
}
?>
<form method="post" id="editform">
    <label for="username">Username:</label><br/>
    <input type="text" id="username" name="username" value="<?= $row[0]['username'] ?>" readonly/><br/><br/>
    <label for="password">Password:</label><br/>
    <input type="password" id="password" name="password"/><br/><br/>
    <label for="role">Role:</label><br/>
    <?=$inputuser?>
    <?=$inputadmin?>
    <input type="submit" value="edit" name="edit"/>
    <?php
    }
    ?>
</form>
</div>
</div>
</body>
</html>