<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการเมนูอาหาร</title>
    <!-- นำเข้า Tailwind CSS -->
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

        /* แผ่นฟิล์มมืดกรองแสงเพื่อให้ตารางและข้อความอ่านง่าย */
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
<body class="min-h-screen p-6 sm:p-10 relative">

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
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include "action/connect.php";

$sql = "SELECT * FROM menus";
$result = mysqli_query($con, $sql);
?>

    <div class="max-w-6xl mx-auto relative z-10">
        <!-- ส่วนหัวและปุ่มเพิ่มข้อมูล -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-lg border border-white/20">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">รายการเมนูอาหาร</h1>
                <p class="text-sm text-gray-500 mt-1">จัดการข้อมูลเมนูอาหาร ราคา และประเภทสินค้าในระบบ</p>
            </div>
            <a href="add_menu.php" class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow transition">
                <!-- ไอคอนบวกแบบง่าย -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                เพิ่มเมนูอาหาร
            </a>
        </div>

        <!-- การ์ดครอบตารางเพื่อความเรียบร้อย -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100/80 border-b border-gray-200 text-gray-600 text-sm font-medium">
                            <th class="px-6 py-4 w-24">รหัสเมนู</th>
                            <th class="px-6 py-4">รูปภาพ</th>
                            <th class="px-6 py-4">ชื่อเมนู</th>
                            <th class="px-6 py-4">ราคา</th>
                            <th class="px-6 py-4">ประเภท</th>
                            <th class="px-6 py-4 text-center w-40">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                        <?php
                        if(mysqli_num_rows($result) > 0) {
                            foreach($result as $menu){
                        ?>
                        <tr class="hover:bg-gray-50/80 transition">
                            <!-- รหัสเมนู -->
                            <td class="px-6 py-4 font-mono text-gray-500">
                                <?= htmlspecialchars($menu["menu_id"]) ?>
                            </td>
                            
                            <!-- ภาพอาหาร (คุมสัดส่วนให้เท่ากัน ไม่เบี้ยว) -->
                            <td class="px-6 py-4">
                                <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shadow-sm flex items-center justify-center">
                                    <?php if(!empty($menu["menu_image"])): ?>
                                        <img src="<?= htmlspecialchars($menu["menu_image"]) ?>" alt="<?= htmlspecialchars($menu["menu_name"]) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">ไม่มีรูป</span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- ชื่อเมนู -->
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <?= htmlspecialchars($menu["menu_name"]) ?>
                            </td>

                            <!-- ราคา -->
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                ฿<?= number_format($menu["menu_price"], 2) ?>
                            </td>

                            <!-- ประเภท (แสดงเป็นรหัสชั่วคราว) -->
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-md text-xs font-medium">
                                    ID: <?= htmlspecialchars($menu["type_id"]) ?>
                                </span>
                            </td>

                            <!-- ปุ่มจัดการ -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="edit_menu.php?id=<?= urlencode($menu["menu_id"]) ?>" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-medium rounded-lg text-xs transition border border-amber-200">
                                        แก้ไข
                                    </a>
                                    <a href="action/delete_menu.php?id=<?= urlencode($menu["menu_id"]) ?>" 
                                       onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบเมนูนี้?')"
                                       class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 font-medium rounded-lg text-xs transition border border-red-200">
                                        ลบ
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                ไม่พบข้อมูลเมนูอาหารในระบบ
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>