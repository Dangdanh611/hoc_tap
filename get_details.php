<?php
require 'connect_db.php';

$response = ['success' => false, 'data' => null];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $data = getData('schedule', "id = $id");

    if ($data) {
        $response['success'] = true;
        $response['data'] = $data[0]; // Lấy dòng đầu tiên (vì id là duy nhất)
    }
}

echo json_encode($response);
?>
