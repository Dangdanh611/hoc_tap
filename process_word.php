<?php
require 'connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['word'])) {
    $word = $_POST['word'];
    $wordtype = $_POST['wordtype'];
    $speak = $_POST['speak'];
    $mean = $_POST['mean'];
    $example = $_POST['example'];

    if (insertData("tu_vung", [
        "word" => $word,
        "wordtype" => $wordtype,
        "speak" => $speak,
        "mean" => $mean,
        "example" => $example
    ])) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}

// Xóa từ vựng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['id'])) {
    $id = $_POST['id'];
    if (deleteData("tu_vung", "id=$id")) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>

