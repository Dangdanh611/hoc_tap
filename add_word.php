<?php require 'connect_db.php'; 
$data = getData("tu_vung"); // Lấy dữ liệu từ bảng tu_vung
require 'head.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Từ Vựng</title>
    <!-- Metronic 5.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@metronic/theme/dist/css/style.bundle.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }

        /* Tăng kích thước ô tìm kiếm và các ô chữ */
        .form-control, .form-select, .btn {
            font-size: 1.2rem;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem; /* Để các ô trông mềm mại */
        }

        /* Chỉnh lại kiểu chữ trong các ô */
        .form-label {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .table th, .table td {
            text-align: center;
            font-size: 1.1rem; /* Tăng kích thước chữ trong bảng */
            padding: 12px;
        }

        .table-container {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #e0e0e0; /* Thêm viền cho bảng */
            border-radius: 8px;
        }

        /* Tăng cỡ chữ trong các ô của bảng */
        .table-dark th, .table-dark td {
            font-size: 1.1rem;
        }

        /* Màu sắc cho các nút xóa và chỉnh sửa */
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 1rem;
        }

    </style>
    <script>
        function fetchWordData() {
            let word = document.getElementById("word").value.trim();
            let wordtype = document.getElementById("wordtype").value;
            if (word && wordtype) {
                $.post("fetch_word_data.php", { word: word, wordtype: wordtype }, function(data) {
                    if (data.success) {
                        document.getElementById("speak").value = data.speak;
                        document.getElementById("mean").value = data.mean;
                    } else {
                        Swal.fire("Lỗi!", "Không tìm thấy thông tin từ vựng.", "error");
                    }
                }, "json");
            }
        }

        function addWord() {
            Swal.fire({
                title: "Bạn có chắc chắn muốn thêm?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Có",
                cancelButtonText: "Không"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đang thêm...",
                        text: "Vui lòng đợi.",
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    let formData = new FormData(document.querySelector("form"));
                    fetch("process_word.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        setTimeout(() => {
                            if (data.success) {
                                let tableBody = document.getElementById("wordTableBody");
                                let newRow = tableBody.insertRow();
                                newRow.innerHTML = `<td>${data.word}</td>
                                                    <td>${data.wordtype}</td>
                                                    <td>${data.speak}</td>
                                                    <td>${data.mean}</td>
                                                    <td>${data.example}</td>
                                                    <td><button class="btn btn-danger btn-sm" onclick="deleteWord(${data.id})">Xóa</button></td>`;

                                Swal.fire("Thành công!", "Từ vựng đã được thêm.", "success");
                                document.querySelector("form").reset();
                            } else {
                                Swal.fire("Lỗi!", "Không thể thêm từ vựng.", "error");
                            }
                        }, 300);
                    });
                }
            });
        }

        function deleteWord(id) {
            Swal.fire({
                title: "Bạn có chắc chắn muốn xóa?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đang xóa...",
                        text: "Vui lòng đợi.",
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    fetch("process_word.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "action=delete&id=" + id
                    })
                    .then(response => response.json())
                    .then(data => {
                        setTimeout(() => {
                            if (data.success) {
                                document.getElementById("row-" + id).remove();
                                Swal.fire("Thành công!", "Từ vựng đã bị xóa.", "success");
                            } else {
                                Swal.fire("Lỗi!", "Không thể xóa từ vựng.", "error");
                            }
                        }, 300);
                    });
                }
            });
        }

    </script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Thêm Từ Vựng</h2>
        <form onsubmit="event.preventDefault(); addWord();">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="word" class="form-label">Từ vựng</label>
                        <input type="text" id="word" name="word" class="form-control" onblur="fetchWordData()" required>
                    </div>
                    <div class="mb-3">
                        <label for="wordtype" class="form-label">Loại từ</label>
                        <select id="wordtype" name="wordtype" class="form-control" onchange="fetchWordData()" required>
                            <option value="">Chọn loại từ</option>
                            <option value="N">Danh từ (N)</option>
                            <option value="V">Động từ (V)</option>
                            <option value="ADJ">Tính từ (ADJ)</option>
                            <option value="ADV">Trạng từ (ADV)</option>
                            <option value="PHV">Cụm động từ (PHV)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="speak" class="form-label">Cách đọc</label>
                        <input type="text" id="speak" name="speak" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mean" class="form-label">Nghĩa</label>
                        <textarea id="mean" name="mean" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="example" class="form-label">Ví dụ</label>
                        <textarea id="example" name="example" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                    <a href="index.php" class="btn btn-secondary">Quay lại</a>
                </div>
                <div class="col-md-6">
                    <h4 class="text-center">Danh Sách Từ Vựng</h4>
                    <div class="table-container">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Từ vựng</th>
                                    <th>Loại từ</th>
                                    <th>Cách đọc</th>
                                    <th>Nghĩa</th>
                                    <th>Ví dụ</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="wordTableBody">
                                <?php foreach ($data as $row): ?>
                                <tr id="row-<?= $row['id'] ?>">
                                    <td><?= htmlspecialchars($row['word']) ?></td>
                                    <td><?= htmlspecialchars($row['wordtype']) ?></td>
                                    <td><?= htmlspecialchars($row['speak']) ?></td>
                                    <td><?= htmlspecialchars($row['mean']) ?></td>
                                    <td><?= htmlspecialchars($row['example']) ?></td>
                                    <td><button class="btn btn-danger btn-sm" onclick="deleteWord(<?= $row['id'] ?>)">Xóa</button></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
