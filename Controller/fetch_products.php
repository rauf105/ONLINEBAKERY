<?php 
include '../Model/db.php';
header('Content-Type: application/json');

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$cat = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

$sql = "SELECT * FROM products WHERE 1=1";
if($search != '') $sql .= " AND (name LIKE '%$search%' OR category LIKE '%$search%')";
if($cat != '') $sql .= " AND category = '$cat'";
$sql .= " ORDER BY id DESC"; 

$res = mysqli_query($conn, $sql);
$products = [];
while($row = mysqli_fetch_assoc($res)) {
    $products[] = $row;
}
echo json_encode($products);
?>