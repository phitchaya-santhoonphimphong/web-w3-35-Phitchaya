<?php
// 1. ตั้งค่าการเชื่อมต่อ
$host     = "localhost";
$username = "root";
$password = "";
$db_name  = "kfc_db";

// 2. เชื่อมต่อฐานข้อมูล
$con = mysqli_connect($host, $username, $password, $db_name);

// 3. ตรวจสอบความผิดพลาด
if (!$con) {
    echo "
    <div style='padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; font-family: Arial, sans-serif; margin: 20px; max-width: 500px;'>
        <strong>❌ เกิดข้อผิดพลาด:</strong> ไม่สามารถเชื่อมต่อฐานข้อมูลได้ <br>
        <small style='color: #666;'>รายละเอียด: " . mysqli_connect_error() . "</small>
    </div>";
    exit();
}

// 4. แสดงผลเมื่อสำเร็จ (ตกแต่งด้วย CSS กล่องสีเขียว)
echo "
<div style='padding: 20px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; font-family: Arial, sans-serif; margin: 20px; max-width: 500px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>
    <h3 style='margin-top: 0; color: #155724;'>🎉 ยินดีด้วย!</h3>
    <p style='margin-bottom: 0;'>การเชื่อมต่อฐานข้อมูล <strong>$db_name</strong> สำเร็จเรียบร้อยแล้ว</p>
</div>";
?>