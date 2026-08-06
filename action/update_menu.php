<?php

$menu_id = $_POST["menu_id"];
$menu_name = $_POST["menu_name"];
$menu_price = $_POST["menu_price"];
$menu_image = $_POST["menu_image"];
$type_id = $_POST["type_id"];

include "connect.php";

$sql = "UPDATE `menus`
SET
`menu_name`='$menu_name',
`menu_price`='$menu_price',
`menu_image`='$menu_image',
`type_id`='$type_id'
WHERE menu_id = '$menu_id' ";

$result = mysqli_query($con , $sql);

if(!$result){
echo "Error";
}else{
header("location: ../manage_menu.php");
exit;
}