<?php
include"db.php";
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role ="user";

    $sql = "insert into users(name,email,password,phone,address,role) values('$name','$email','$password','$phone','$address','$role')";
    $result =mysqli_query($conn,$sql);
    if(!$result){
        echo "Error!: {$conn->error}";
    }
    else{
       echo "Resistered successfully"; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register page</title>
    <style>
        .registerdiv {
            margin-top: 200px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: center;
        }

        .shoplink {
            display: block;
            width: 100px;
            position: fixed;
            top: 20%;
            left: 45%;
            text-align: center;
            text-decoration: none;
            background-color: lightgreen;
            padding: 10px;
        }

        .registerdiv input {
            display: block;
            padding: 15px;
            margin: 8px;
        }
        .registerdiv textarea {
            display: block;
            padding: 15px;
            margin: 8px;
            width: 162px
        }
        .button{
            width: 200px;
            background-color: lightcoral;
            border: none;
        }
        .button:hover{
            background-color: darkorange;
        }
        .registerdiv a{
            margin-left: 5px;
        
        }
    </style>
</head>
<body>
    <a class="shoplink" href="index.php">Shop</a>
    <div class="registerdiv">
        <form action="register.php" method="post">
            <input type="text" name="name" placeholder="Enter Your Name" require>
            <input type="email" name="email" placeholder="Enter Your Email" require>
            <input type="password" name="password" placeholder="Enter Your Password" require>
            <input type="text" name="phone" placeholder="Enter Your Number" require>
            <textarea name="address" placeholder="Enter Your Address"></textarea>
            <input class="button" type="submit" name="submit" value="sign up">
            <p>Go for login...<a href="login.php">Login</a></p>
        </form>

    </div>

</body>

</html>