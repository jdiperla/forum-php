<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add a Reply</title>
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
        $(document).ready(function()
        {
            $('#replyform').submit(function(e){
                e.preventDefault();
                var form_data = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: 'function/addreply.php',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result){
                         if(result=="success")
                            {
                               window.location.href = document.referrer;
                            }
                            else {
                               alert(result); 
                            }
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
if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
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
         <li><a href="thread.php?id=<?=$_GET['id']?>&type=<?=$_GET['type']?>">Return to thread page</a></li>
         <li><a href="logout.php">Logout</a></li>
         <li><a href="changepassword.php">Change password</a></li>
       </ul>  
     </div>
   </nav>
    <?php
}
else{
    header("Location: index.php", true, 301);
    exit();
    ?>
    <?php

}
?>
<div id="content">
<h2>Add reply</h2>
<div id="form">
<form id="replyform" method="post" enctype="multipart/form-data" >
<div class="form-group row">
            <div class="col-xs-3">
    <label for="content">Reply Message Body:</label><br/>
    <textarea rows="5" cols="30" name="content" id="content" required></textarea>
    </div>
    </div>
    <label for="attachment"><b>Attachments:</b></label><br/>
    <div>
        <input type="file" name="files[]" multiple="" />
    </div><br/>
    <input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
    <input type="submit" value="OK" class="btn btn-success"/>
</form>
</div>
</div>
</div>
</body>
</html>
