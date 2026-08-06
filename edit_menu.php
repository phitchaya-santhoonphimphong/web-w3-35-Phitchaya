<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขเมนูอาหาร</title>
    <!-- นำเข้า Tailwind CSS เพื่อความสวยงามแบบโมเดิร์น -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- นำเข้า Google Fonts ภาษาไทย -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
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

        /* แผ่นฟิล์มมืดกรองแสงเพื่อให้ฟอร์มและตัวหนังสืออ่านง่ายขึ้น */
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
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative">

<!-- ================= วิดีโอพื้นหลัง YouTube (เพิ่มส่วนนี้) ================= -->
<div class="video-bg-container">
    <iframe 
        src="https://www.youtube.com/embed/qs4rvkftMzU?autoplay=1&mute=1&loop=1&playlist=qs4rvkftMzU&controls=0&showinfo=0&modestbranding=1" 
        frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
    </iframe>
</div>
<div class="video-overlay"></div>
<!-- ====================================================================== -->

<?php
$id = $_GET['id'];
include "action/connect.php";

$sql = "SELECT * FROM menus WHERE menu_id = '$id' ";
$result = mysqli_query($con, $sql);
$menu = mysqli_fetch_assoc($result);
?>

    <div class="bg-white/95 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-md border border-white/20 relative z-10">
        <!-- หัวข้อฟอร์ม -->
        <div class="mb-6 text-center">
            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full uppercase tracking-wide">Edit Menu</span>
            <h2 class="text-2xl font-semibold text-gray-800 mt-2">แก้ไขข้อมูลเมนู</h2>
            <p class="text-sm text-gray-500 mt-1">กรอกข้อมูลด้านล่างเพื่ออัปเดตรายการอาหาร</p>
        </div>

        <form action="action/update_menu.php" method="post" class="space-y-5">
            
            <!-- รหัสเมนู (ห้ามแก้ไขเพื่อความปลอดภัยของ Database) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">รหัสเมนู</label>
                <input type="text" name="menu_id" value="<?= htmlspecialchars($menu['menu_id']) ?>" readonly
                       class="w-full px-4 py-2 bg-gray-100/80 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed focus:outline-none font-mono">
            </div>

            <!-- ชื่อเมนู -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อเมนู</label>
                <input type="text" name="menu_name" value="<?= htmlspecialchars($menu['menu_name']) ?>" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
            </div>

            <!-- ราคา -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ราคา (บาท)</label>
                <input type="number" name="menu_price" value="<?= htmlspecialchars($menu['menu_price']) ?>" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
            </div>

            <!-- รูปภาพ -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อไฟล์รูปภาพ / URL</label>
                <input type="text" name="menu_image" value="<?= htmlspecialchars($menu['menu_image']) ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
            </div>

            <!-- ประเภทเมนู -->
            <?php
            // ดึงข้อมูลประเภทเมนู
            $sql_types = "SELECT * FROM menu_types";
            $result_types = mysqli_query($con, $sql_types);
            ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ประเภทเมนู</label>
                <select name="type_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    <?php foreach($result_types as $type){ ?>
                        <option value="<?= $type["type_id"] ?>" <?= $type["type_id"] == $menu["type_id"] ? "selected" : '' ?>>
                            <?= htmlspecialchars($type["type_name"]) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- ปุ่มกด -->
            <div class="pt-2 flex space-x-3">
                <a href="index.php" class="w-1/3 text-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition text-sm flex items-center justify-center">
                    ยกเลิก
                </a>
                <button type="submit" class="w-2/3 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow transition text-sm">
                    บันทึกการเปลี่ยนแปลง
                </button>
            </div>

        </form>
    </div>

</body>
</html>