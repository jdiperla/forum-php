<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create a Thread</title>
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
        #form{
            margin-top:20px
        }
        </style>
    <script>
        $(document).ready(function () {
            $('#threadform').submit(function (e) {
                e.preventDefault();
                var form_data = new FormData(this);
                
                $.ajax({
                    type: 'POST',
                    url: 'function/addthread.php',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {             
        window.location.replace("thread.php?id="+result+"&type=<?= $_GET['type']?>")
                    },
                    error: function (error) {
                        alert(error);
                    }
                });
            });
        });
    </script>
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
         <li><a href="category.php?type=<?=$_GET['type']?>">Return to category page</a></li>
         <li><a href="logout.php">Logout</a></li>
         <li><a href="changepassword.php">Change password</a></li>
       </ul>  
     </div>
   </nav>
    <?php
} else {
    header("Location: index.php", true, 301);
    exit();
    ?>
    <?php
}
?>
<div id="content">
<h2>Create a Thread</h2>
<div id="form">
<form id="threadform" method="post" enctype="multipart/form-data">
<div class="form-group row">
            <div class="col-xs-3">
    <label for="topic">Thread Topic:</label><br/>
    <input type="text" id="topic" name="topic" class="form-control" required/>
    </div>
    </div>
    <div class="form-group row">
            <div class="col-xs-3">
    <label for="content">Thread Message:</label><br/>
    <textarea rows="5" cols="30" name="content" id="content" class="form-control" required></textarea>
    </div>
    </div>
    <label for="attachment"><b>Attachments:</b></label><br/>
    <div>
        <input type="file" name="files[]" multiple=""/>
    </div>
    <br/>
    <input type="hidden" id="type" name="type" value="<?= $_GET['type'] ?>"/>
    <input type="submit" value="OK" class="btn btn-success"/>
</form>
</div>
</div>
</div>
</body>
</html>
