<!DOCTYPE html>
<?php
session_start();
require_once "../class/User.php";
require_once "../class/Database.php";
$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$sql="SELECT user.username ,user.password ,GROUP_CONCAT(user_roles.role SEPARATOR ',') as role FROM user,user_roles WHERE user.username=user_roles.username GROUP BY user.username";
$stmt = $user->selectMutiUser($sql);
?>
<html>
<head>
    <title>Admin page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                        window.location.replace("index.php");
                    }
                });
                return false;
            });
        });
    </script>
</head>
<style>
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
</style>
<body>
<?php
if(isset($_SESSION['username']) && !empty($_SESSION['username']) && $_SESSION['role']=="admin") {
    ?>
    <nav>
    <b>Hello <?= $_SESSION['username'] ?></b> |
    <a href="../logout.php">Logout</a> |
    <a href="../index.php">Return to main home page</a>
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
<h2>Admin Page</h2>
<h3>User list</h3>

<?php
if($stmt && $stmt->rowCount() >0){
    ?>
<table>
    <tr>
        <th>Username</th>
        <th>Password</th>
        <th>Roles</th>
        <th>Action</th>
    </tr>
<?php
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
    ?>
    <tr>
        <td><?=$row['username']?></td>
        <td><?=$row['password']?></td>
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
</body>
</html>