<!DOCTYPE html>
<?php
session_start();
require_once "../class/User.php";
require_once "../class/Database.php";
$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$sql="SELECT user.username ,user.password ,GROUP_CONCAT(user_roles.role SEPARATOR ',') as role FROM user,user_roles WHERE user.username=user_roles.username GROUP BY user.username ORDER BY user.user_id";
$stmt = $user->selectMutiUser($sql);
?>
<html>
<head>
    <title>Admin page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script>

        $(document).ready(function()
        {
            $(".delete").click(function() {
                //Do stuff when clicked
                var username = $(this).parent().siblings(":first").text();
                $.ajax
                ({
                    url: 'function/deleteuser.php',
                    data: {"username": username},
                    type: 'post',
                    success: function(result)
                    {
                        if(data=="success")
                        {
                            alert("ok");
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
<style> 
    @import url(http://fonts.googleapis.com/css?family=Oswald:400,300,700);
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
        text-align: left;
    }
    th {
        background-color: #eee;
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
        #content{
            padding-left: 10px;
        }
</style>
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
<h2>Admin Page</h2>
<h3>User list</h3>

<?php
if($stmt && $stmt->rowCount() >0){
    ?>
<table>
    <tr>
        <th>Username</th>
        <th>Roles</th>
        <th>Action</th>
    </tr>
<?php
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    ?>
    <tr>
        <td><?=$row['username']?></td>
        <td><?=$row['role']?></td>
        <td>
            <a href="" class="delete">Delete</a>
            <a href="edituser.php?name=<?=$row['username']?>">Edit</a>
        </td>
    </tr>
    <?php
}
echo "</table>";
}
else{
   echo " <i>There are no users in the system.</i>";
}
?>
</div>
</div>
</body>
</html>