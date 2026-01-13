<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] == "admin") {
    } else {
        echo "go for uder dashboard";
    }
} else {
    header("Location: ../intex.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .dashboard_sideber{
            position: fixed;
            top: 0;
            background-color: lightcoral;
            width: 200px;
            height: 100%;
        }
        .dashboard_sideber ul li{
            list-style: none;
            text-align: center;
        }
        .dashboard_sideber ul li a{
            padding: 10px;
            border-radius: 10px;
            display: block;
            text-decoration: none;

        }
        .dashboard_sideber ul li a:hover{
            background-color: lightgray;
        }
        .dashboard_main{
            padding: 30px;
            margin-left: 200px;
        }
    </style>
</head>

<body>
    <div class="dashboard_sideber">
        <ul>
            <li><a href="">Add Product</a></li>
            <li><a href="">View Order</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="dashboard_main">
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugiat aliquam eius, minus tempora quae quos ab perspiciatis ducimus? Ducimus, consequuntur ab accusamus quaerat impedit culpa dignissimos dolor consectetur odit ipsum!</p>
    </div>
</body>

</html>