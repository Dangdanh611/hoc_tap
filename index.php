<!-- index.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Học Tập</title>
    <!-- Include head.php -->
    <?php require 'head.php'; ?>
    <style>
        /* Tăng kích thước Swal */
.swal-large {
    width: 50% !important; /* Tăng chiều rộng của hộp thoại */
    max-width: 600px; /* Giới hạn chiều rộng tối đa */
}

.swal-title-large {
    font-size: 1.5rem !important; /* Tăng kích thước chữ tiêu đề */
}

.swal-content-large {
    font-size: 1.2rem !important; /* Tăng kích thước chữ nội dung */
}

        /* Điều chỉnh lại bảng cho rõ nét hơn */
        .table-container {
            max-height: 600px;
            overflow-y: auto;
            border-radius: 8px;
        }

        /* Bảng có đường nét đậm rõ ràng */
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
            padding: 15px;
            border: 2px solid #ddd;  /* Viền đậm hơn */
        }

        /* Đường viền bảng trong chế độ tối rõ ràng */
        .dark-mode .table th, .dark-mode .table td {
            border: 2px solid #444; /* Viền tối, đậm hơn */
        }

        /* Chỉnh lại màu chữ */
        .dark-mode .table {
            color: #E0E0E0; /* Chữ sáng hơn trong chế độ tối */
        }

        /* Chữ đen đậm hơn */
        body {
            font-weight: 600; /* Chữ đậm cho chế độ sáng */
        }

        /* Chữ trong bảng khi ở chế độ tối */
        .dark-mode .table th, .dark-mode .table td {
            color: #f0f0f0;  /* Chữ sáng hơn một chút */
        }

        /* Hover rõ nét hơn */
        .table tbody tr:hover {
            background-color: #dcdcdc; /* Màu hover sáng hơn trong chế độ sáng */
        }

        /* Hover bảng trong chế độ tối */
        .dark-mode .table tbody tr:hover {
            background-color: #3a3a52;  /* Màu hover trong chế độ tối, không quá sáng */
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center fw-bold text-primary">📅 Lịch Học Tập</h2>

        <form id="search-form" class="d-flex justify-content-between align-items-center mb-4">
            <input type="date" name="day" class="form-control w-25" id="search_day">
            <select name="subject" class="form-select w-25" id="search_subject">
                <option value="">Chọn môn</option>
                <option value="Toán">Toán</option>
                <option value="Anh">Anh</option>
                <option value="KHTN">KHTN</option>
                <option value="Văn">Văn</option>
            </select>
            <select name="status" class="form-select w-25" id="search_status">
                <option value="">Chọn trạng thái</option>
                <option value="pending">Đang chờ...</option>
                <option value="done">Thành công</option>
                <option value="cancel">Hủy</option>
            </select>
        </form>


        <!-- Bảng hiển thị dữ liệu -->
        <div class="table-container">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>📅 Ngày</th>
                        <th>📖 Thứ</th>
                        <th>📚 Môn</th>
                        <th>📝 Nội dung</th>
                        <th>📌 Trạng thái</th>
                        <th>⚙️ Thao tác</th>
                    </tr>
                </thead>
                <tbody id="schedule-table-body">
                    <!-- Dữ liệu sẽ được điền ở đây thông qua AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Lấy ngày hôm nay và đặt vào input
            let today = new Date().toISOString().split('T')[0];
            $('#search_day').val(today);

            // Gọi AJAX khi trang tải hoặc khi thay đổi ngày/môn/trạng thái
            function fetchSchedule() {
                var search_day = $('#search_day').val();
                var search_subject = $('#search_subject').val();
                var search_status = $('#search_status').val();

                // Format ngày thành dd-mm-yyyy
                if (search_day) {
                    var dayParts = search_day.split('-');
                    search_day = `${dayParts[2]}-${dayParts[1]}-${dayParts[0]}`;
                }

                // Gửi AJAX
                $.post('handle_search.php', {
                    day: search_day,
                    subject: search_subject,
                    status: search_status
                }, function(response) {
                    var data = JSON.parse(response);
                    var tbody = $('#schedule-table-body');
                    tbody.empty();

                    data.forEach(function(row) {
                        var statusBtn = '';
                        if (row.status === 'cancel') {
                            statusBtn = '<button class="btn btn-danger btn-sm">❌ Hủy</button>';
                        } else if (row.status === 'done') {
                            statusBtn = '<button class="btn btn-success btn-sm">✅ Thành công</button>';
                        } else {
                            statusBtn = '<button class="btn btn-warning btn-sm">⏳ Đang chờ...</button>';
                        }

                        var rowHtml = `<tr id="row-${row.id}">
                            <td>${row.day}</td>
                            <td>${row.session}</td>
                            <td>${row.subject}</td>
                            <td>${row.note}</td>
                            <td>${statusBtn}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="viewDetails(${row.id})">👀 Xem</button>
                                <button class="btn btn-success btn-sm" onclick="confirmAction('done', ${row.id})">✔️ Done</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmAction('cancel', ${row.id})">❌ Cancel</button>
                            </td>
                        </tr>`;
                        tbody.append(rowHtml);
                    });
                });
            }

            // Gọi tự động khi trang load
            fetchSchedule();

            // Gọi lại khi chọn ngày/môn/trạng thái
            $('#search_day, #search_subject, #search_status').on('change', fetchSchedule);
        });

        function viewDetails(id) {
            $.post('get_details.php', {id: id}, function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Chi tiết lịch học',
                        html: `<strong>Môn:</strong> ${response.data.subject}<br>
                               <strong>Nội dung:</strong> ${response.data.note}<br>
                               <strong>Thông tin thêm:</strong> ${response.data.information}`,
                        showConfirmButton: true
                    });
                } else {
                    Swal.fire('Lỗi!', 'Không thể tải thông tin chi tiết.', 'error');
                }
            }, 'json');
        }

        function confirmAction(action, id) {
            let actionText = action === 'done' ? 'hoàn thành' : 'hủy';
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: 'Hành động này không thể hoàn tác!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Không'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('setting.php', {action: action, id: id}, function(response) {
                        if (response.success) {
                            Swal.fire('Thành công!', 'Trạng thái đã được cập nhật.', 'success');
                            let row = $('#row-' + id);
                            if (action === 'done') {
                                row.find('td').eq(4).html('<button class="btn btn-success btn-sm">✅ Thành công</button>');
                            } else if (action === 'cancel') {
                                row.find('td').eq(4).html('<button class="btn btn-danger btn-sm">❌ Hủy</button>');
                            }
                        }
                    }, 'json');
                }
            });
        }
    </script>
</body>
</html>
