<?php
//                      ที่อยู่ฐาน,         ชื่อผู้ใช้, รหัส, ชื่อฐาน
$con = mysqli_connect("localhost", "root", "", "kfc_db");

// ทดสอบการเชื่อมต่อ
// สำเร็จ  $con = true
// ผิดพลาด  $con = false

if(!$con){
    die("เชื่อมต่อสำเร็จ");
}

echo "การเชื่อมต่อสำเร็จ";