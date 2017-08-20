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
<?php
if(isset($_SESSION['username']) && !empty($_SESSION['username']) && $_SESSION['role']=="admin") {
    ?>
    <nav>
    <b>Hello <?= $_SESSION['username'] ?></b> |
    <a href="../logout.php">Logout</a> |
    <a href="index.php">Return to Admin Page</a>
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
</body>
</html>