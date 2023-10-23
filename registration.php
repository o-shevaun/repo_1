<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user registration</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<?php
if(isset($_POST['create'])){
   $name = $_POST['name'];
   $password = $_POST['password'];
   $id = $_POST['id'];
   $email = $_POST['email'];

  
   

   echo $name." " ."has just registered";
}

?>
<div>

</div>
    <div>
        <form action="registration.php" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        
                <h1> Registration </h1><br>
                <p>Fill form</p>
<label for="name"><b>name</b></label>
<input class="form-control" type="text" placeholder="Enter name" name="name" required><br/>

<label for="email"><b>email</b></label>
<input class="form-control" type="email" placeholder="Enter email" name="email" required><br/>

<label for="password"><b>password</b></label>
<input class="form-control" type="password" placeholder="Enter password" name="password" required><br/>

<label for="id"><b>id</b></label>
<input class="form-control" type="text" placeholder="Enter id" name="id" required><br/>

<input class="btn btn-primary" type="submit"  name="create" value="register"> 
</div>
</div>

            </div>

        </form>
    </div>

</body>
</html>