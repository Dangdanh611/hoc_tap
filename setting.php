<?php
require 'connect_db.php';

// Kiểm tra nếu có action và id được truyền vào
if (isset($_POST['action']) && isset($_POST['id'])) {
    $action = $_POST['action'];
    $id = $_POST['id'];

    // Xử lý cập nhật trạng thái
    $status = ($action == 'done') ? 'done' : 'cancel';

    // Sử dụng hàm updateData để cập nhật trạng thái
    $update = updateData('schedule', ['status' => $status], "id = $id");

    if ($update) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
