<?php
require 'connect_db.php';

// Lấy giá trị từ form tìm kiếm
$search_day = $_POST['day'] ?? '';
$search_subject = $_POST['subject'] ?? '';
$search_status = $_POST['status'] ?? '';

// Tạo câu truy vấn tìm kiếm
$where = "1";  // Mặc định là lấy tất cả dữ liệu

if ($search_day) {
    $where .= " AND day = '$search_day'";
}
if ($search_subject) {
    $where .= " AND subject = '$search_subject'";
}
if ($search_status) {
    $where .= " AND status = '$search_status'";
}

// Lấy dữ liệu từ database sau khi tìm kiếm
$data = getData("schedule", $where);

// Trả dữ liệu về dạng JSON để index.php nhận và hiển thị
echo json_encode($data);
?>
