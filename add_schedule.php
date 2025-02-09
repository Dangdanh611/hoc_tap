<?php require 'connect_db.php'; 
$data = getData("schedule"); // Lấy dữ liệu từ bảng schedule
require 'head.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Lịch Học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .table-container {
            max-height: 500px; /* Bạn có thể điều chỉnh chiều cao tối đa ở đây */
            overflow-y: auto; /* Khi nội dung vượt quá chiều cao này sẽ xuất hiện thanh cuộn */
        }

        /* Thay đổi kích thước các ô nhập liệu */
        .form-control {
            font-size: 1.2rem;  /* Tăng kích thước chữ trong các ô nhập */
            padding: 1rem;      /* Tăng độ rộng của ô nhập */
        }

        /* Tăng kích thước chữ trong nhãn */
        .form-label {
            font-size: 1.1rem;  /* Tăng kích thước chữ của nhãn */
            font-weight: bold;  /* Làm chữ đậm */
        }

        /* Tăng kích thước chữ nút bấm */
        .btn {
            font-size: 1.1rem;  /* Tăng kích thước chữ của nút bấm */
            padding: 0.8rem 1.5rem; /* Tăng độ rộng và cao của nút bấm */
        }

        /* Tăng chiều cao của các hàng trong bảng */
        .table td, .table th {
            padding: 1rem;  /* Tăng độ cao của các hàng */
        }

        /* Cải thiện diện mạo các ô nhập liệu */
        .table-container {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Tăng độ rộng cột bảng */
        .table th, .table td {
            text-align: center;
            font-size: 1.1rem;
        }
    </style>
<script>
    function updateSession() {
        let dayInput = document.getElementById("day").value;
        if (!dayInput) return;
        let date = new Date(dayInput);
        let days = ["Chủ nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"];
        document.getElementById("session").value = days[date.getDay()];
    }

    function updateTable() {
        // Xác nhận trước khi thêm
        Swal.fire({
            title: 'Bạn có chắc chắn muốn thêm?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Có',
            cancelButtonText: 'Không'
        }).then(result => {
            if (result.isConfirmed) {
                // Hiển thị loading trước khi thực hiện
                Swal.fire({
                    title: 'Đang thêm...',
                    text: 'Vui lòng đợi một chút.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Thực hiện thao tác thêm
                let formData = new FormData(document.querySelector("form"));
                fetch("process_schedule.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    setTimeout(() => {
                        if (data.success) {
                            let tableBody = document.getElementById("scheduleTableBody");
                            let newRow = tableBody.insertRow();
                            newRow.innerHTML = `<td>${data.day}</td>
                                                <td>${data.session}</td>
                                                <td>${data.subject}</td>
                                                <td>${data.note}</td>
                                                <td>${data.status}</td>
                                                <td><button class="btn btn-danger btn-sm" onclick="deleteData(${data.id})">Xóa</button></td>`;

                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thêm thành công!',
                                text: 'Lịch học đã được thêm vào.',
                            });

                            // Xóa nội dung các ô nhập liệu
                            document.querySelector("form").reset();
                        } else {
                            // Hiển thị thông báo thất bại
                            Swal.fire({
                                icon: 'error',
                                title: 'Thêm thất bại!',
                                text: 'Đã có lỗi xảy ra khi thêm lịch học.',
                            });
                        }
                    }, 300); // Delay 300ms
                });
            }
        });
    }

    function deleteData(id) {
        // Xác nhận trước khi xóa
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then(result => {
            if (result.isConfirmed) {
                // Hiển thị loading trước khi thực hiện
                Swal.fire({
                    title: 'Đang xóa...',
                    text: 'Vui lòng đợi một chút.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Thực hiện thao tác xóa
                fetch(`process_schedule.php?action=delete&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    setTimeout(() => {
                        if (data.success) {
                            // Xóa dòng khỏi bảng
                            document.getElementById("row-" + id).remove();

                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Xóa thành công!',
                                text: 'Lịch học đã bị xóa.',
                            });
                        } else {
                            // Hiển thị thông báo thất bại
                            Swal.fire({
                                icon: 'error',
                                title: 'Xóa thất bại!',
                                text: 'Đã có lỗi xảy ra khi xóa lịch học.',
                            });
                        }
                    }, 300); // Delay 300ms
                });
            }
        });
    }
</script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Thêm Lịch Học</h2>
        <form onsubmit="event.preventDefault(); updateTable();">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="day" class="form-label">Ngày</label>
                        <input type="date" id="day" name="day" class="form-control" onchange="updateSession()" required>
                    </div>
                    <div class="mb-3">
                        <label for="session" class="form-label">Thứ</label>
                        <input type="text" id="session" name="session" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Môn</label>
                        <input type="text" id="subject" name="subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Nội dung</label>
                        <textarea id="note" name="note" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="information" class="form-label">Thông tin thêm</label>
                        <textarea id="information" name="information" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                    <a href="index.php" class="btn btn-secondary">Quay lại</a>
                </div>
                <div class="col-md-6">
                    <h4 class="text-center">Danh Sách Lịch Học</h4>
                 <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Ngày</th>
                                <th>Thứ</th>
                                <th>Môn</th>
                                <th>Nội dung</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                    </div>
                        <tbody id="scheduleTableBody">
                            <?php foreach ($data as $row): ?>
                            <tr id="row-<?= $row['id'] ?>">
                                <td><?= htmlspecialchars($row['day']) ?></td>
                                <td><?= htmlspecialchars($row['session']) ?></td>
                                <td><?= htmlspecialchars($row['subject']) ?></td>
                                <td><?= htmlspecialchars($row['note']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td><button class="btn btn-danger btn-sm" onclick="deleteData(<?= $row['id'] ?>)">Xóa</button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
