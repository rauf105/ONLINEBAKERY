<?php
$conn = mysqli_connect("localhost", "root", "", "baking_valley");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>