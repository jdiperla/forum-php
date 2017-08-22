<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Forum Login</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script>
            $(document).ready(function ()
            {
                $('#editpform').submit(function ()
                {
                    $.ajax({
                        type: "POST",
                        url: "function/changepassword.php",
                        data: $('#editpform').serialize(),
                        cache: false,
                        success: function (data) {
                            if (data == "success")
                            {
                                alert("password successfully changed!")
                                window.location.replace("index.php");
                            } else {
                                if (!$('#message').length) {
                                    $('#error').prepend('<p id="message">Change password failed! Please try again!</p>');
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
        if (!isset($_SESSION['username']) && empty($_SESSION['username'])) {
            header("Location: index.php", true, 301);
            exit();
        }
        ?>
        <nav>
            <b>Hello <?= $_SESSION['username'] ?></b> |
            <a href="logout.php">Logout</a> |
            <a href="index.php">Return to home page</a> |
            <a href="changepassword.php">Change password</a> 
        </nav>
        <h2>Change password</h2>
        <div id="error"></div>
        <form id="editpform" method="post">
            <label for="username">Username:</label><br/>
            <input type="text" id="username" name="username" value="<?= $_SESSION['username'] ?>" readonly required /><br/><br/>
            <label for="password">New Password:</label><br/>
            <input type="password" id="password" name="password" required/><br/><br/>
            <input type="submit" value="OK"/>
        </form>
    </body>
</html>