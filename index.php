<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการรายการอาหาร</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #ff4757; /* สีแดงสดใสแนวร้านอาหาร */
            --primary-hover: #ff6b81;
            --secondary-color: #2f3542; /* สีกรมท่าเข้มเพิ่มความหรูหรา */
            --card-bg: rgba(255, 255, 255, 0.92); /* สีขาวโปร่งแสง */
            --text-muted: #747d8c;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            color: var(--secondary-color);
            padding: 40px 20px;
            margin: 0;
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- ส่วนของ VIDEO BACKGROUND --- */
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
            min-width: 177.77vh; /* อัตราส่วน 16:9 */
            transform: translate(-50%, -50%) scale(1.2); /* ขยายเล็กน้อยกันขอบดำ */
            pointer-events: none;
        }

        /* แผ่นสีดำโปร่งแสงทับวิดีโอ เพื่อให้ข้อความและตารางอ่านง่ายขึ้น */
        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.65); /* ฉากหลังเข้มแบบมีมิติ */
            backdrop-filter: blur(4px); /* เพิ่มเอฟเฟกต์เบลอ */
            z-index: -1;
        }

        .main-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* ส่วนหัวข้อ */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
            background: rgba(255, 255, 255, 0.85);
            padding: 20px 24px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }
        
        .header-title h1 {
            font-size: 28px;
            color: var(--secondary-color);
            margin: 0 0 6px 0;
            font-weight: 700;
        }
        
        .header-title p {
            color: var(--text-muted);
            margin: 0;
            font-size: 14px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }
        
        /* ปุ่มกดต่างๆ */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 71, 87, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background-color: white;
            color: var(--secondary-color);
            border: 1px solid #ced6e0;
        }

        .btn-outline:hover {
            background-color: #f1f2f6;
        }
        
        /* กล่องครอบตาราง */
        .table-container {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        /* หัวตาราง */
        thead {
            background: linear-gradient(135deg, var(--secondary-color), #4b5261);
            color: white;
        }

        th {
            padding: 18px 24px;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
        }

        /* แถวตาราง */
        td {
            padding: 16px 24px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 15px;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.4);
        }

        tr:hover {
            background-color: rgba(255, 250, 240, 0.9); 
            transition: background-color 0.2s ease;
        }

        /* ตกแต่ง Badge */
        .badge-id {
            background-color: #eccc68;
            color: #333;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            font-family: monospace;
        }

        .badge-type {
            background-color: #e8f4fd;
            color: #1e90ff;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }

        /* ราคา */
        .price-tag {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 17px;
        }

        /* รูปภาพอาหาร */
        .img-wrapper {
            width: 120px;
            height: 80px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background-color: #f1f2f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .img-wrapper:hover .menu-img {
            transform: scale(1.08);
        }

        .no-img {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ปุ่มแก้ไข / ลบ */
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-right: 5px;
            transition: all 0.2s;
        }

        .btn-edit {
            background-color: #fff9db;
            color: #f59f00;
            border: 1px solid #ffe066;
        }
        .btn-edit:hover {
            background-color: #fff3bf;
        }

        .btn-delete {
            background-color: #fff5f5;
            color: #fa5252;
            border: 1px solid #ffc9c9;
        }
        .btn-delete:hover {
            background-color: #ffe3e3;
        }
        
        .empty-row {
            text-align: center;
            color: var(--text-muted);
            padding: 40px !important;
        }
    </style>
</head>
<body>

<!-- Background Video (เล่นวนลูปและปิดเสียงอัตโนมัติ) -->
<div class="video-bg-container">
    <iframe 
        src="https://www.youtube.com/embed/qs4rvkftMzU?autoplay=1&mute=1&loop=1&playlist=qs4rvkftMzU&controls=0&showinfo=0&modestbranding=1&enablejsapi=1" 
        frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
    </iframe>
</div>

<!-- แผ่นสีดำกรองแสงพื้นหลัง -->
<div class="video-overlay"></div>

<?php
// เปิดแสดงข้อผิดพลาดเพื่อตรวจเช็คบั๊ก
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "action/connect.php";

// ดึงข้อมูลเมนู พร้อมกับเชื่อมตารางประเภทเมนู (INNER JOIN) เพื่อนำชื่อประเภทมาแสดงผลแทนเลข ID ซ้ำ
$sql = "SELECT menus.*, menu_types.type_name 
        FROM menus 
        LEFT JOIN menu_types ON menus.type_id = menu_types.type_id";
$result = mysqli_query($con, $sql);
?>

<div class="main-wrapper">
    <!-- ส่วนหัวหน้าจอรวมเป็นจุดเดียว -->
    <div class="header-section">
        <div class="header-title">
            <h1>ระบบจัดการรายการอาหาร</h1>
            <p>รวมเมนูทั้งหมดที่มีอยู่ในระบบฐานข้อมูลปัจจุบัน</p>
        </div>
        <div class="action-buttons">
            <a href="menu.php" class="btn btn-outline">ดูหน้าเมนูหลัก</a>
            <a href="add_menu.php" class="btn btn-primary">+ เพิ่มเมนูอาหาร</a>
        </div>
    </div>

    <!-- ตารางแสดงรายการ -->
    <div class="table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 100px;">รหัสเมนู</th>
                        <th style="width: 150px;">ภาพอาหาร</th>
                        <th>ชื่อเมนู</th>
                        <th style="width: 120px;">ราคา</th>
                        <th style="width: 150px;">ประเภท</th>
                        <th style="width: 160px; text-align: center;">การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(mysqli_num_rows($result) > 0) {
                    foreach($result as $menu){
                ?>
                    <tr>
                        <!-- รหัสเมนู -->
                        <td><span class="badge-id"><?= htmlspecialchars($menu["menu_id"]) ?></span></td>
                        
                        <!-- รูปภาพเมนู -->
                        <td>
                            <div class="img-wrapper">
                                <?php if(!empty($menu["menu_image"])): ?>
                                    <img src="<?= htmlspecialchars($menu["menu_image"]) ?>" alt="" class="menu-img">
                                <?php else: ?>
                                    <span class="no-img">ไม่มีรูปภาพ</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        
                        <!-- ชื่อเมนู -->
                        <td style="font-weight: 600; color: #1e2229;">
                            <?= htmlspecialchars($menu["menu_name"]) ?>
                        </td>
                        
                        <!-- ราคา -->
                        <td><span class="price-tag">฿<?= number_format((float)$menu["menu_price"], 2) ?></span></td>
                        
                        <!-- ประเภทอาหาร (แสดงชื่อประเภทแทน รหัสเมนู) -->
                        <td>
                            <span class="badge-type">
                                <?= !empty($menu["type_name"]) ? htmlspecialchars($menu["type_name"]) : 'ทั่วไป' ?>
                            </span>
                        </td>
                        
                        <!-- ปุ่มแก้ไข/ลบ -->
                        <td style="text-align: center;">
                            <a href="edit_menu.php?id=<?= urlencode($menu["menu_id"]) ?>" class="btn-action btn-edit">แก้ไข</a>
                            <a href="action/delete_menu.php?id=<?= urlencode($menu["menu_id"]) ?>" 
                               onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบเมนูนี้?')" 
                               class="btn-action btn-delete">ลบ</a>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="6" class="empty-row">ไม่มีข้อมูลรายการอาหารในระบบ</td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>