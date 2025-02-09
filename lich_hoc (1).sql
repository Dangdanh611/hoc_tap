-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 09, 2025 lúc 11:06 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lich_hoc`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `day` varchar(255) NOT NULL,
  `session` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `information` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `schedule`
--

INSERT INTO `schedule` (`id`, `day`, `session`, `subject`, `note`, `information`, `status`, `time`) VALUES
(20, '04-02-2025', 'Thứ Ba', 'Tiếng Anh', 'Ngữ Pháp', 'Học cấu tạo từ ngữ và bài tập (Học 1h làm 30p)', 'cancel', '2025-02-04 12:11:54'),
(21, '04-02-2025', 'Thứ Ba', 'Toán', 'Làm đề thi', 'Đề thi thử vào 10 tỉnh VP. \r\nLink: file:///C:/Users/Admin/Downloads/de-tham-khao-tuyen-sinh-lop-10-mon-toan-nam-2025-2026-so-gddt-vinh-phuc.pdf', 'done', '2025-02-04 12:17:12'),
(22, '04-02-2025', 'Thứ Ba', 'Tìm hiểu', 'Xem YTB', 'Xem video tết mậu thân 1968, biển đảo VN của CD Team', 'cancel', '2025-02-04 12:18:36'),
(23, '04-02-2025', 'Thứ Ba', 'Hóa', 'Làm bài tập', 'Làm hết bài ethylic alcohol trong sách bài tập và mở rộng', 'done', '2025-02-04 12:19:27'),
(24, '04-02-2025', 'Thứ Ba', 'Bài Tập về nhà', 'Làm các môn', 'Chép Nhạc,...', 'done', '2025-02-04 12:20:02'),
(25, '05-02-2025', 'Thứ Tư', 'Anh', 'Ôn bài + Từ vựng', 'Ôn lại bài cũ và học từ vựng unit 2 sách lớp 8 (1 tiếng 30p)', 'done', '2025-02-04 12:20:50'),
(26, '05-02-2025', 'Thứ Tư', 'Tìm Hiểu', 'Xem YTB', 'Xem về bếp Hoàng Cầm', 'done', '2025-02-04 12:21:11'),
(27, '05-02-2025', 'Thứ Tư', 'KHTN', 'Làm đề thi thử', 'Làm đề thi KHTN 9 của Hải Phòng.\r\nhttps://848603edf5.vws.vegacdn.vn//data/doc/haiphong/2024/thcsnguyenbinhkhiem/ntmhuong/2024_11/1/khtnde_111202414.docx', 'cancel', '2025-02-04 12:25:51'),
(28, '05-02-2025', 'Thứ Tư', 'Toán', 'Tìm hiểu', 'Tìm hiểu về bất đẳng thức cộng mẫu số svac-xơ\r\n', 'done', '2025-02-04 13:07:19'),
(29, '09-02-2025', 'Chủ nhật', 'gfh', 'yth', 'gfh', 'pending', '2025-02-09 14:58:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tu_vung`
--

CREATE TABLE `tu_vung` (
  `id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `wordtype` varchar(50) NOT NULL,
  `speak` varchar(255) NOT NULL,
  `mean` text NOT NULL,
  `example` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tu_vung`
--

INSERT INTO `tu_vung` (`id`, `word`, `wordtype`, `speak`, `mean`, `example`) VALUES
(3, 'good', 'N', '/ɡʊ(d)/', '(of people)', 'AEFAE'),
(4, 'Into', 'N', '/ˈɪn.tuː/', 'Vào trong', 'szrgdr'),
(6, 'hello', 'N', '/həˈləʊ/', 'Xin chào', ''),
(8, 'hello', 'N', '/həˈləʊ/', 'Xin chào', 'gh'),
(12, 'good', 'V', '/ɡʊ(d)/', 'Tốt', ''),
(13, 'good', 'V', '/ɡʊ(d)/', 'Tốt', ''),
(14, 'Hello', 'N', '/həˈloʊ/', 'Xin chào', ''),
(15, 'Hello', 'N', '/həˈloʊ/', 'Xin chào', 'xcfbdf'),
(17, 'Hello', 'N', '/həˈləʊ/', 'Xin chào', ''),
(18, 'Into', 'N', '/ˈɪn.tuː/', 'Vào trong', 'hii lô\r\n'),
(19, 'kiss', 'N', '/kɪs/', 'hôn', ''),
(21, 'fuck', 'V', '/fʊk/', 'Mẹ kiếp', 'fuck you:))'),
(22, 'because', 'N', '/bɪˈkɒz/', 'bởi vì', 'beacause... I ....');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tu_vung`
--
ALTER TABLE `tu_vung`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `tu_vung`
--
ALTER TABLE `tu_vung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
