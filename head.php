<!-- head.php -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lịch Học Tập</title>

<!-- Import Font chuẩn Metronic -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Metronic CSS -->
<link href="theme/style.bundle.css" rel="stylesheet">
<script src="theme/scripts.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    /* Font chữ chuẩn của Metronic */
    body {
        font-family: "Poppins", sans-serif !important;
        font-size: 1.15rem;
        font-weight: 400;
        line-height: 1.6;
    }

    /* 🌙 Chế độ tối - Màu tím than */
    .dark-mode {
        background-color: #1B1E2D; /* Tím than đậm */
        color: #E0E0E0; /* Chữ sáng hơn */
    }

    .dark-mode .table {
        background-color: #25273C; /* Tím than nhạt */
        color: #E0E0E0;
    }

    /* Viền bảng rõ hơn */
    .table th, .table td {
        padding: 14px;
        font-size: 1.15rem;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    /* Hover không bị trắng xóa */
    .dark-mode .table tbody tr:hover {
        background-color: #2D3050 !important;
    }

    /* Chỉnh lại button */
    .button-container {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 20px;
    }

    .btn {
        font-size: 1rem;
        padding: 12px 16px;
        border-radius: 6px;
        font-weight: 500;
    }
</style>

<!-- Button menu -->
<div class="button-container">
    <a href="lichhoc" class="btn btn-primary">📅 Lịch học tập</a>
    <a href="editlich" class="btn btn-success">📝 Edit lịch</a>
    <a href="bangtu" class="btn btn-info">📖 Bảng từ vựng</a>
    <a href="edittu" class="btn btn-warning">✏️ Edit từ</a>
    <button class="btn btn-dark" onclick="toggleDarkMode()">🌙 Chế độ tối</button>
    <button class="btn btn-danger" onclick="location.reload()">🔄 Làm mới</button>
</div>

<script>
    // 🌙 Lưu trạng thái chế độ tối vào localStorage
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        let mode = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
        localStorage.setItem('theme', mode);
    }

    // Khi load lại trang, kiểm tra chế độ sáng/tối từ localStorage
    document.addEventListener("DOMContentLoaded", function() {
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    });
</script>
