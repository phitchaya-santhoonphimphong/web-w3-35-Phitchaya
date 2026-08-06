<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>จัดการประเภทเมนูอาหาร</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-color: #ff4757; /* สีแดงสดใสแนวร้านอาหาร */
        --secondary-color: #2f3542; /* สีกรมท่าเข้มเพิ่มความหรูหรา */
        --bg-color: #f1f2f6;
        --card-bg: rgba(255, 255, 255, 0.95); /* ปรับความโปร่งแสงรองรับ Glassmorphism */
    }

    body {
        font-family: 'Sarabun', sans-serif;
        color: var(--secondary-color);
        padding: 40px 20px;
        margin: 0;
        min-height: 100vh;
        position: relative;
    }

    /* --- สไตล์สำหรับ Video Background --- */
    .video-bg-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -2;
        overflow: hidden;
        pointer-events: none;
    }

    .video-bg-container iframe {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100vw;
        height: 56.25vw; /* อัตราส่วน 16:9 */
        min-height: 100vh;
        min-width: 177.77vh;
        transform: translate(-50%, -50%) scale(1.2);
        pointer-events: none;
    }

    /* แผ่นฟิล์มมืดกรองแสงเพื่อให้ตารางและข้อความอ่านง่ายขึ้น */
    .video-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: -1;
    }

    /* ส่วนหัวข้อตกแต่ง */
    .header-title {
        text-align: center;
        margin-bottom: 30px;
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
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
        max-width: 800px;
        margin: 0 auto;
        background-color: var(--card-bg);
        backdrop-filter: blur(8px);
        border-radius: 16px; /* ขอบมนสวยๆ */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* เงานุ่มนวล */
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.3);
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
        background-color: rgba(250, 250, 250, 0.5);
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
</style>
</head>
<body>

<!-- ================= วิดีโอพื้นหลัง YouTube (คลิปใหม่) ================= -->
<div class="video-bg-container">
    <iframe 
        src="https://www.youtube.com/embed/fq2WzkeYdLc?autoplay=1&mute=1&loop=1&playlist=fq2WzkeYdLc&controls=0&showinfo=0&modestbranding=1" 
        frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
    </iframe>
</div>
<div class="video-overlay"></div>
<!-- ====================================================================== -->

<div class="header-title">
    <h1>ระบบจัดการประเภทเมนูอาหาร</h1>
    <p>รวมประเภทเมนูทั้งหมดที่มีอยู่ในระบบฐานข้อมูลปัจจุบัน</p>
    
    <a href="index.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background-color: var(--primary-color); color: white; text-decoration: none; border-radius: 8px; font-weight: bold; transition: opacity 0.2s;">
        ดูหน้าเมนูหลัก
    </a>
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
$sql = "SELECT * FROM menu_types";
// ที่อยู่ฐาน , คิวรี่
$result = mysqli_query($con , $sql);
?>

<div class="table-container">
    <table>
    <thead>
        <tr>
            <th style="width: 30%;">รหัสประเภท</th>
            <th>ชื่อประเภทเมนู</th>
        </tr>
    </thead>

    <tbody>
    <?php
    foreach($result as $menu_types){
    ?>

    <tr>
        <td><span class="badge-id"><?= htmlspecialchars($menu_types["type_id"]) ?></span></td>
        <td style="font-weight: 600;"><?= htmlspecialchars($menu_types["type_name"]) ?></td>
    </tr>

    <?php
    }
    ?>
    </tbody>

    </table>
</div>

</body>
</html>