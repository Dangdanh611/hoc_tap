<?php
// Thiết lập múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lich_hoc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Hàm chèn dữ liệu
function insertData($table, $data) {
    global $conn;
    $columns = implode(", ", array_keys($data));
    $values = implode(", ", array_fill(0, count($data), "?"));
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($data)), ...array_values($data));
    return $stmt->execute();
}

// Hàm lấy dữ liệu
function getData($table, $where = "1") {
    global $conn;
    $sql = "SELECT * FROM $table WHERE $where";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Hàm cập nhật dữ liệu
function updateData($table, $data, $where) {
    global $conn;
    $set = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));
    $sql = "UPDATE $table SET $set WHERE $where";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($data)), ...array_values($data));
    return $stmt->execute();
}

// Hàm xóa dữ liệu
function deleteData($table, $where) {
    global $conn;
    $sql = "DELETE FROM $table WHERE $where";
    return $conn->query($sql);
}
?>
