<?php
if (!isset($_POST['word']) || !isset($_POST['wordtype'])) {
    echo json_encode(["success" => false, "message" => "Thiếu dữ liệu."]);
    exit;
}

$word = $_POST['word'];
$wordtype = $_POST['wordtype'];

// API lấy phiên âm (Dictionary API v2)
$dict_api_url = "https://api.dictionaryapi.dev/api/v2/entries/en/$word";
$dict_response = file_get_contents($dict_api_url);
$dict_data = json_decode($dict_response, true);

$phonetics = "";
if (isset($dict_data[0]['phonetics'])) {
    foreach ($dict_data[0]['phonetics'] as $phonetic) {
        if (!empty($phonetic['text'])) {
            $phonetics = $phonetic['text'];
            break;
        }
    }
}

// API Google Translate để dịch nghĩa
$google_translate_url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=vi&dt=t&q=" . urlencode($word);
$translate_response = file_get_contents($google_translate_url);
$translate_data = json_decode($translate_response, true);

$translated_meaning = isset($translate_data[0][0][0]) ? $translate_data[0][0][0] : "";

echo json_encode([
    "success" => true,
    "speak" => $phonetics,
    "mean" => $translated_meaning
]);
?>

