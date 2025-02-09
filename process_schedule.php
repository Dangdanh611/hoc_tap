<?php
require 'connect_db.php';

$response = ['success' => false];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = $_POST['day']; // Định dạng ngày nhận được từ form (YYYY-MM-DD)
    $session = $_POST['session'];
    $subject = $_POST['subject'];
    $note = $_POST['note'];
    $information = $_POST['information'];
    $status = "pending"; // Mặc định để trống

    // Chuyển đổi ngày từ YYYY-MM-DD sang DD-MM-YYYY
    $dateArray = explode("-", $day); // Tách ngày, tháng, năm
    $formattedDay = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0]; // Định dạng DD-MM-YYYY

    // Thêm vào database
    if (insertData("schedule", [
        "day" => $formattedDay,
        "session" => $session,
        "subject" => $subject,
        "note" => $note,
        "information" => $information,
        "status" => $status
    ])) {
        // Trả về thông tin thành công
        $response = [
            'success' => true,
            'day' => $formattedDay,
            'session' => $session,
            'subject' => $subject,
            'note' => $note,
            'status' => $status,
            'id' => $conn->insert_id
        ];
    }
    echo json_encode($response);
} elseif (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if (deleteData("schedule", "id=$id")) {
        $response['success'] = true;
    }
    echo json_encode($response);
}
?>
