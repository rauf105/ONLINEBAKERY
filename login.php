<?php
    include "db.php";
    session_start();
    if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "select * from users where email ='$email'";
    $result =mysqli_query($conn,$sql);
    if($result->num_rows>0){
        $row =mysqli_fetch_assoc($result);
        if($row['password'] == $password){
           $_SESSION['user_id'] = $row['id'];
           $_SESSION['user_name'] = $row['name'];
           $_SESSION['user_role'] = $row['role'];
           if($_SESSION['user_role'] == "admin"){
            header("Location: admin/dashboard.php");
           }
           else{
            echo "dashboard for user";
           }

        }
        else{
            echo "Wrong password";
        }
    }
    else{
       echo "Please sign up first"; 
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
    <style>
        .login{
            position: fixed;
            top: 25%;
            left: 40%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: darkgray;
            padding: 30px;
        }
        .login input{
            display: block;
            border-radius: 15px;
            border-bottom: 2px solid darkolivegreen;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 5px;

        }
        .login a{
            margin-left: 5px;
        
        }
        .button{
            border: 2px solid darkblue;
            background-color: lightgreen;
            width: 100%;
        }

    </style>
</head>

<body>
    <div class="login">
        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="Enter Your Email" require>
            <input type="password" name="password" placeholder="Enter Your Password" require>
            <input class="button" type="submit" name="submit" value="login">
            <p>Don't have accunt...<a href="register.php">Sign up</a></p>
        </form>
    </div>
</body>

</html>