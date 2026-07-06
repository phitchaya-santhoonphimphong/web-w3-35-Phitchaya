<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-color: #ff4757; /* สีแดงสดใสแนวร้านอาหาร */
        --secondary-color: #2f3542; /* สีกรมท่าเข้มเพิ่มความหรูหรา */
        --bg-color: #f1f2f6;
        --card-bg: #ffffff;
    }

    body {
        font-family: 'Sarabun', sans-serif;
        background-color: var(--bg-color);
        color: var(--secondary-color);
        padding: 40px 20px;
        margin: 0;
    }

    /* ส่วนหัวข้อตกแต่งเพิ่มความแกรนด์ */
    .header-title {
        text-align: center;
        margin-bottom: 30px;
    }
    .header-title h1 {
        font-size: 28px;
        color: var(--secondary-color);
        margin: 0 0 10px 0;
        font-weight: 700;
    }
    .header-title p {
        color: #747d8c;
        margin: 0;
        font-size: 14px;
    }
    
    /* กล่องครอบตาราง */
    .table-container {
        max-width: 1100px;
        margin: 0 auto;
        background-color: var(--card-bg);
        border-radius: 16px; /* ขอบมนสวยๆ */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); /* เงานุ่มนวล */
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.03);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    /* หัวตารางไล่เฉดสี */
    thead {
        background: linear-gradient(135deg, var(--secondary-color), #4b5261);
        color: white;
    }

    th {
        padding: 18px 24px;
        font-weight: 600;
        font-size: 15px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    /* แถวตาราง */
    td {
        padding: 16px 24px;
        border-bottom: 1px solid #f1f2f6;
        font-size: 15px;
        vertical-align: middle; /* จัดให้อยู่กึ่งกลางแนวตั้ง */
    }

    /* สลับสีแถวให้ดูง่ายขึ้น (Zebra Striping) */
    tr:nth-child(even) {
        background-color: #fdfdfd;
    }

    /* เอฟเฟกต์ชี้แล้วเรืองแสง */
    tr:hover {
        background-color: #fffaf0; 
        transition: background-color 0.2s ease;
    }

    /* ตกแต่งรหัสเมนูให้เหมือน Badge */
    .badge-id {
        background-color: #eccc68;
        color: #333;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    /* ตกแต่งราคาให้เด่นชัด */
    .price-tag {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 16px;
    }

    /* ตกแต่งรูปภาพเมนูให้เหมือนแอปสั่งอาหาร */
    .menu-img {
        width: 140px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }

    /* เวลาเอาเมาส์ชี้ที่รูปภาพ ภาพจะขยายใหญ่ขึ้นนิดนึง */
    .menu-img:hover {
        transform: scale(1.08);
    }
</style>
</head>
<body>

<div class="header-title">
    <h1>ระบบจัดการรายการอาหาร</h1>
    <p>รวมเมนูทั้งหมดที่มีอยู่ในระบบฐานข้อมูลปัจจุบัน</p>
</div>

<?php
//แสดง error

// Report all PHP errors
error_reporting(E_ALL);

// Force errors to be displayed on the screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "action/connect.php";

// ดึง ทัั้งหมด จาก ตาราง menus
$sql = "SELECT * FROM menus";
// ที่อยู่ฐาน , คิวรี่
$result = mysqli_query($con , $sql);
// ทดสอบ
// var_dump($result);
?>

<div class="table-container">
    <table>
    <thead>
    <th>รหัสเมนู</th>
    <th>ชื่อเมนู</th>
    <th>ราคา</th>
    <th>ภาพ</th>
    <th>ประเภท</th>
    </thead>

    <?php
    foreach($result as $menu){
    ?>

    <tr>
    <td><span class="badge-id"><?= $menu["menu_id"] ?></span></td>
    <td style="font-weight: 600;"><?= $menu["menu_name"] ?></td>
    <td><span class="price-tag">฿<?= number_format((float)$menu["menu_price"], 2) ?></span></td>
    <td>
    <img
    src="<?= $menu["menu_image"] ?>"
    alt=""
    class="menu-img"
    >
    </td>
    <td><?= $menu["menu_id"] ?></td>
    </tr>

    <?php
    }
    ?>

    </table>
</div>

</body>
</html>