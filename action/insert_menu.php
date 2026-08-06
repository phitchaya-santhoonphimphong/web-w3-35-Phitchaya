<?php

$menu_id = $_POST["menu_id"];
$menu_name = $_POST["menu_name"];
$menu_price = $_POST["menu_price"];
$menu_image = $_POST["menu_image"];
$type_id = $_POST["type_id"];

include "connect.php";

$sql = "INSERT INTO `menus`
(`menu_id`, `menu_name`, `menu_price`, `menu_image`, `type_id`)
VALUES
('$menu_id','$menu_name','$menu_price','$menu_image','$type_id')";

$result = mysqli_query($con , $sql);

if(!$result){
echo "Error";
}else{
header("location: ../index.php");
exit;
}
