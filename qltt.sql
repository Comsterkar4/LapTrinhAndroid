-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 19, 2025 lúc 10:20 AM
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
-- Cơ sở dữ liệu: `qltt`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binh_luan`
--

CREATE TABLE `binh_luan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nguoi_dung_id` int(10) UNSIGNED NOT NULL,
  `truyen_id` int(10) UNSIGNED NOT NULL,
  `noi_dung` text NOT NULL,
  `ngay_binh_luan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `binh_luan`
--

INSERT INTO `binh_luan` (`id`, `nguoi_dung_id`, `truyen_id`, `noi_dung`, `ngay_binh_luan`) VALUES
(19, 25, 5, 'Hi truyen hay qua', '2025-04-16 13:34:00'),
(20, 25, 3, 'Hi', '2025-04-16 13:37:50'),
(21, 25, 6, 'Truyen hay', '2025-04-16 13:44:29'),
(22, 25, 6, 'App dep', '2025-04-16 13:44:39'),
(23, 25, 4, 'hi', '2025-04-16 18:54:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuong`
--

CREATE TABLE `chuong` (
  `id` int(10) UNSIGNED NOT NULL,
  `truyen_id` int(10) UNSIGNED NOT NULL,
  `ten` varchar(255) NOT NULL,
  `so_chuong` int(10) UNSIGNED NOT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chuong`
--

INSERT INTO `chuong` (`id`, `truyen_id`, `ten`, `so_chuong`, `ngay_tao`) VALUES
(8, 3, 'Chương 1', 1, '2025-04-14 17:03:34'),
(9, 3, 'Chương 2', 2, '2025-04-14 17:03:34'),
(13, 3, 'Chương 3', 3, '2025-04-15 15:24:43'),
(14, 5, 'Chuong 1', 1, '2025-04-16 13:30:13'),
(16, 5, 'Chuong 1', 1, '2025-04-18 07:59:08'),
(17, 6, 'Chuong 1', 1, '2025-04-18 07:59:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_gia`
--

CREATE TABLE `danh_gia` (
  `id` int(10) UNSIGNED NOT NULL,
  `nguoi_dung_id` int(10) UNSIGNED NOT NULL,
  `truyen_id` int(10) UNSIGNED NOT NULL,
  `diem` int(11) NOT NULL,
  `ngay_danh_gia` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoat_dong_nguoi_dung`
--

CREATE TABLE `hoat_dong_nguoi_dung` (
  `id` int(10) UNSIGNED NOT NULL,
  `nguoi_dung_id` int(10) UNSIGNED NOT NULL,
  `truyen_id` int(10) UNSIGNED NOT NULL,
  `chuong_cuoi_doc` int(10) UNSIGNED DEFAULT NULL,
  `yeu_thich` int(11) DEFAULT 0,
  `cap_nhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoat_dong_nguoi_dung`
--

INSERT INTO `hoat_dong_nguoi_dung` (`id`, `nguoi_dung_id`, `truyen_id`, `chuong_cuoi_doc`, `yeu_thich`, `cap_nhat`) VALUES
(63, 25, 5, 1, 1, '2025-04-18 10:01:19'),
(65, 25, 4, 0, 1, '2025-04-16 18:54:47'),
(69, 25, 3, 2, 1, '2025-04-19 08:19:11'),
(71, 25, 6, 1, 1, '2025-04-18 10:01:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(10) UNSIGNED NOT NULL,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp(),
  `ho_ten` varchar(100) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `id_vai_tro` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ten_dang_nhap`, `mat_khau`, `email`, `ngay_tao`, `ho_ten`, `avatar`, `id_vai_tro`) VALUES
(25, 'Comster', '1', 'User@gmail.com', '2025-04-16 13:33:44', NULL, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/Naruto/Chuong1/4.jpg', 1),
(26, 'admin', '1', 'admin@gmail.com', '2025-04-16 18:55:33', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `the_loai`
--

CREATE TABLE `the_loai` (
  `id` int(10) UNSIGNED NOT NULL,
  `ten_the_loai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `the_loai`
--

INSERT INTO `the_loai` (`id`, `ten_the_loai`) VALUES
(5, 'Hài Hước'),
(1, 'Hành động'),
(6, 'Mạo Hiểm'),
(4, 'Nija'),
(2, 'Phiêu Lưu'),
(3, 'Tu Tiên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trang`
--

CREATE TABLE `trang` (
  `id` int(10) UNSIGNED NOT NULL,
  `chuong_id` int(10) UNSIGNED NOT NULL,
  `so_trang` int(10) UNSIGNED NOT NULL,
  `duong_dan_anh` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trang`
--

INSERT INTO `trang` (`id`, `chuong_id`, `so_trang`, `duong_dan_anh`) VALUES
(14, 8, 1, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/TienNghich/Chuong1/img_00001.jpg'),
(16, 8, 3, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/TienNghich/Chuong1/img_00003.jpg'),
(17, 8, 4, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/TienNghich/Chuong1/img_00004.jpg'),
(19, 8, 6, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/TienNghich/Chuong2/img_00005.jpg'),
(21, 9, 2, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/TienNghich/Chuong1/img_00003.jpg'),
(22, 9, 3, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/TienNghich/Chuong1/img_00004.jpg'),
(23, 13, 5, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/TienNghich/Chuong1/img_00004.jpg'),
(24, 14, 1, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/Naruto/Chuong1/1.jpg'),
(25, 14, 2, 'https://raw.githubusercontent.com/Comsterkar4/image-android/blob/main/Naruto/Chuong1/2.jpg'),
(26, 14, 3, 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/Naruto/Chuong1/4.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trang_thai`
--

CREATE TABLE `trang_thai` (
  `id` int(10) UNSIGNED NOT NULL,
  `ten_trang_thai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trang_thai`
--

INSERT INTO `trang_thai` (`id`, `ten_trang_thai`) VALUES
(2, 'Hoàn thành'),
(1, 'Đang cập nhật');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `truyen`
--

CREATE TABLE `truyen` (
  `id` int(10) UNSIGNED NOT NULL,
  `ten` varchar(255) NOT NULL,
  `tac_gia` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `anh_bia` text DEFAULT NULL,
  `id_trang_thai` int(10) UNSIGNED NOT NULL,
  `luot_xem` int(10) UNSIGNED DEFAULT 0,
  `luot_thich` int(10) UNSIGNED DEFAULT 0,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `truyen`
--

INSERT INTO `truyen` (`id`, `ten`, `tac_gia`, `mo_ta`, `anh_bia`, `id_trang_thai`, `luot_xem`, `luot_thich`, `ngay_tao`) VALUES
(3, 'Tien Nghich', 'Nhĩ Căn', 'Tiên Nghịch kể về Vương Lâm – một thiếu niên bình thường, thông minh, luôn hiếu thuận với cha mẹ. Trải qua những biến cố, Vương Lâm bước vào con đường tu tiên đầy gian nan. Không giống với các truyện tiên hiệp thông thường, Tiên Nghịch nổi bật với diễn biến tâm lý sâu sắc, thế giới quan rộng lớn và những tình tiết cuốn hút, cảm động.', 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/TienNghich/tiennghich.jpg', 1, 0, 0, '2025-04-14 12:43:21'),
(4, 'SoloLeveling', 'Chugong', 'Solo Leveling kể về Sung Jin-Woo, một thợ săn yếu nhất trong thế giới đầy quái vật và dungeon. Sau một nhiệm vụ chết người, anh có được một hệ thống cho phép anh mạnh lên không giới hạn. Từ một kẻ yếu đuối, anh dần trở thành Thợ Săn mạnh nhất thế giới. Cốt truyện gay cấn, đồ họa đẹp mắt và những màn chiến đấu mãn nhãn là điểm nổi bật của bộ truyện.', 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/SoloLeveling/solo.webp', 1, 0, 0, '2025-04-14 12:45:30'),
(5, 'Naruto', 'Masashi Kishimotoo', 'Naruto là câu chuyện về Uzumaki Naruto – một cậu bé tinh nghịch, bị mọi người trong làng xa lánh vì mang trong mình Cửu Vĩ Hồ. Với ước mơ trở thành Hokage – người đứng đầu làng Lá, Naruto không ngừng cố gắng vượt qua khó khăn, kết bạn và trưởng thành qua từng trận chiến khốc liệt. Đây là một trong những bộ manga shounen kinh điển, truyền cảm hứng mạnh mẽ cho nhiều thế hệ độc giả.', 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/Naruto/naruto.jpg', 1, 0, 0, '2025-04-14 12:46:55'),
(6, 'Quan Gia Ta La Ma Hoang', 'Dạ Kiêu', 'Đại Quản Gia Là Ma Hoàng của tác giả Dạ Kiêu là một tác phẩm huyền huyễn nổi bật, thu hút độc giả bởi cốt truyện cuốn hút và nhân vật đầy chiều sâu. Câu chuyện về Trác Phàm, một Ma Hoàng bị phản bội và phải trùng sinh với những âm mưu và trận chiến khốc liệt, mang lại cho người đọc những cảm xúc mạnh mẽ và những bài học sâu sắc. Trong bài viết này, hãy cùng TruyenGG đánh giá chi tiết về “Đại Quản Gia Là Ma Hoàng,” từ văn phong, cốt truyện cho đến cách xây dựng nhân vật, để hiểu rõ hơn vì sao tác phẩm này lại có sức hấp dẫn đặc biệt đến vậy', 'https://raw.githubusercontent.com/Comsterkar4/image-android/main/qu%E1%BA%A3n%20gia%20c%E1%BB%A7a%20ta%20l%C3%A0%20ma%20ho%C3%A0ng/qg.jpg', 1, 0, 0, '2025-04-14 13:42:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `truyen_theloai`
--

CREATE TABLE `truyen_theloai` (
  `id` int(11) NOT NULL,
  `id_truyen` int(10) UNSIGNED NOT NULL,
  `id_the_loai` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `truyen_theloai`
--

INSERT INTO `truyen_theloai` (`id`, `id_truyen`, `id_the_loai`) VALUES
(15, 3, 1),
(6, 4, 1),
(13, 5, 1),
(14, 5, 2),
(12, 6, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vaitro`
--

CREATE TABLE `vaitro` (
  `id` int(10) UNSIGNED NOT NULL,
  `ten_vai_tro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vaitro`
--

INSERT INTO `vaitro` (`id`, `ten_vai_tro`) VALUES
(2, 'admin'),
(1, 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `truyen_id` (`truyen_id`);

--
-- Chỉ mục cho bảng `chuong`
--
ALTER TABLE `chuong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `truyen_id` (`truyen_id`);

--
-- Chỉ mục cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `truyen_id` (`truyen_id`);

--
-- Chỉ mục cho bảng `hoat_dong_nguoi_dung`
--
ALTER TABLE `hoat_dong_nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-truyen` (`truyen_id`),
  ADD KEY `fk-nguoidung` (`nguoi_dung_id`),
  ADD KEY `fk-chuong` (`chuong_cuoi_doc`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_vai_tro` (`id_vai_tro`);

--
-- Chỉ mục cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_the_loai` (`ten_the_loai`);

--
-- Chỉ mục cho bảng `trang`
--
ALTER TABLE `trang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chuong_id` (`chuong_id`);

--
-- Chỉ mục cho bảng `trang_thai`
--
ALTER TABLE `trang_thai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_trang_thai` (`ten_trang_thai`);

--
-- Chỉ mục cho bảng `truyen`
--
ALTER TABLE `truyen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_trang_thai` (`id_trang_thai`);

--
-- Chỉ mục cho bảng `truyen_theloai`
--
ALTER TABLE `truyen_theloai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_truyen` (`id_truyen`,`id_the_loai`),
  ADD KEY `id_the_loai` (`id_the_loai`);

--
-- Chỉ mục cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_vai_tro` (`ten_vai_tro`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `chuong`
--
ALTER TABLE `chuong`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hoat_dong_nguoi_dung`
--
ALTER TABLE `hoat_dong_nguoi_dung`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `trang`
--
ALTER TABLE `trang`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `trang_thai`
--
ALTER TABLE `trang_thai`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `truyen`
--
ALTER TABLE `truyen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `truyen_theloai`
--
ALTER TABLE `truyen_theloai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `binh_luan_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `binh_luan_ibfk_2` FOREIGN KEY (`truyen_id`) REFERENCES `truyen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chuong`
--
ALTER TABLE `chuong`
  ADD CONSTRAINT `chuong_ibfk_1` FOREIGN KEY (`truyen_id`) REFERENCES `truyen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`truyen_id`) REFERENCES `truyen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `hoat_dong_nguoi_dung`
--
ALTER TABLE `hoat_dong_nguoi_dung`
  ADD CONSTRAINT `fk-nguoidung` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-truyen` FOREIGN KEY (`truyen_id`) REFERENCES `truyen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD CONSTRAINT `nguoi_dung_ibfk_1` FOREIGN KEY (`id_vai_tro`) REFERENCES `vaitro` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `trang`
--
ALTER TABLE `trang`
  ADD CONSTRAINT `trang_ibfk_1` FOREIGN KEY (`chuong_id`) REFERENCES `chuong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `truyen`
--
ALTER TABLE `truyen`
  ADD CONSTRAINT `truyen_ibfk_2` FOREIGN KEY (`id_trang_thai`) REFERENCES `trang_thai` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `truyen_theloai`
--
ALTER TABLE `truyen_theloai`
  ADD CONSTRAINT `truyen_theloai_ibfk_1` FOREIGN KEY (`id_truyen`) REFERENCES `truyen` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `truyen_theloai_ibfk_2` FOREIGN KEY (`id_the_loai`) REFERENCES `the_loai` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
