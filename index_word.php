<?php 
require 'connect_db.php'; 
$data = getData("tu_vung"); // Lấy dữ liệu từ bảng tu_vung
require 'head.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Từ Vựng</title>
    <style>
        /* Bảng từ vựng giống bảng lịch học */
.table-container {
    max-height: 500px;
    overflow-y: auto;
    border-radius: 8px;
    border: 1px solid #ddd;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Tạo kiểu dáng giống bảng lịch học */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1rem;
}

th, td {
    padding: 12px;
    text-align: center;
    font-family: 'Arial', sans-serif;
    border: 1px solid #ddd;
    color: #333;
}

/* Cải thiện kiểu dáng của tiêu đề */
th {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
}

/* Cải thiện màu sắc và làm đẹp các ô dữ liệu */
td {
    background-color: #f8f9fa;
    transition: background-color 0.3s;
}

/* Hiệu ứng hover cho các dòng trong bảng */
tr:hover td {
    background-color: #e2e6ea;
}

/* Làm đẹp các ô input tìm kiếm */
.form-control {
    font-size: 1rem;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ced4da;
}

/* Tạo hiệu ứng cho ô input khi focus */
input[type="text"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Cải thiện giao diện tổng thể */
.container {
    max-width: 90%;
    margin: 0 auto;
}

h2 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: #007bff;
}

/* Cải thiện layout tìm kiếm */
.search-container .col-md-4 {
    margin-bottom: 10px;
}

    </style>
    <script>
        // Tìm kiếm theo từ vựng và nghĩa
        function searchWords() {
            let word = document.getElementById("word_search").value.toLowerCase();
            let mean = document.getElementById("mean_search").value.toLowerCase();
            let table = document.getElementById("wordTableBody");
            let rows = table.getElementsByTagName("tr");
            
            for (let row of rows) {
                let wordColumn = row.getElementsByTagName("td")[0].textContent.toLowerCase();
                let meanColumn = row.getElementsByTagName("td")[3].textContent.toLowerCase();

                if (wordColumn.includes(word) && meanColumn.includes(mean)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Danh Sách Từ Vựng</h2>
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="word_search" class="form-control" placeholder="Tìm kiếm theo từ vựng" onkeyup="searchWords()">
            </div>
            <div class="col-md-4">
                <input type="text" id="mean_search" class="form-control" placeholder="Tìm kiếm theo nghĩa" onkeyup="searchWords()">
            </div>
        </div>
        <div class="table-container">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Từ</th>
                        <th>Loại từ</th>
                        <th>Phát âm</th>
                        <th>Nghĩa</th>
                        <th>Ví dụ</th>
                    </tr>
                </thead>
                <tbody id="wordTableBody">
                    <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['word']) ?></td>
                        <td><?= htmlspecialchars($row['wordtype']) ?></td>
                        <td><?= htmlspecialchars($row['speak']) ?></td>
                        <td><?= htmlspecialchars($row['mean']) ?></td>
                        <td><?= htmlspecialchars($row['example']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
