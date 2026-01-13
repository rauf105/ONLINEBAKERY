<?php
$conn = new mysqli('localhost','root','','onlinebakerydb');
if(!$conn){
    echo "Error!: {$conn->connection_error}";
}
?>