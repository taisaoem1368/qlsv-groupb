-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2019 at 05:28 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlsv`
--

-- --------------------------------------------------------

--
-- Table structure for table `absent_information`
--

CREATE TABLE `absent_information` (
  `ai_id` int(55) NOT NULL,
  `ai_student_id` int(55) NOT NULL,
  `ai_absences` int(55) DEFAULT NULL,
  `ai_discipline_id` int(5) NOT NULL,
  `ai_semester` int(5) NOT NULL,
  `ai_year` int(10) NOT NULL,
  `ai_delete` int(5) NOT NULL COMMENT '0 : hide 1 : show',
  `ai_teacher_code_edit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_time_edit` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absent_information`
--

INSERT INTO `absent_information` (`ai_id`, `ai_student_id`, `ai_absences`, `ai_discipline_id`, `ai_semester`, `ai_year`, `ai_delete`, `ai_teacher_code_edit`, `ai_time_edit`) VALUES
(1383, 1307, 1, 2, 1, 2019, 1, 'superadmin', '2019-05-10 17:03:44.000000');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(55) NOT NULL,
  `class_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `class_teacher_id` int(55) NOT NULL,
  `class_course_id` int(55) NOT NULL,
  `class_major_id` int(55) NOT NULL,
  `class_old_teacher_id` int(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`, `class_code`, `class_teacher_id`, `class_course_id`, `class_major_id`, `class_old_teacher_id`) VALUES
(113, 'CD17TT4', 'CD17TT4', 77, 4, 1, NULL),
(114, 'CÔNG NGHỆ THÔNG TIN 1', 'CD16TT1', 78, 3, 1, NULL),
(115, 'CÔNG NGHỆ THÔNG TIN 2', 'CD16TT2', 79, 3, 1, NULL),
(116, 'CÔNG NGHỆ THÔNG TIN 3', 'CD16TT3', 80, 3, 1, NULL),
(117, 'CÔNG NGHỆ THÔNG TIN 4', 'CD16TT4', 81, 3, 1, NULL),
(118, 'CÔNG NGHỆ THÔNG TIN 5', 'CD16TT5', 82, 3, 1, NULL),
(119, 'CÔNG NGHỆ THÔNG TIN 6', 'CD16TT6', 83, 3, 1, NULL),
(120, 'CÔNG NGHỆ THÔNG TIN 7', 'CD16TT7', 84, 3, 1, NULL),
(121, 'TRUYỀN THÔNG VÀ MẠNG MÁY TÍNH 1', 'CD16TM1', 85, 3, 2, NULL),
(122, 'THIẾT KẾ ĐỒ HỌA 1', 'CD16ĐH1', 86, 3, 3, NULL),
(123, 'CÔNG NGHỆ THÔNG TIN 1', 'CD17TT1', 87, 4, 1, NULL),
(124, 'CÔNG NGHỆ THÔNG TIN 2', 'CD17TT2', 79, 4, 1, NULL),
(125, 'CÔNG NGHỆ THÔNG TIN 3', 'CD17TT3', 80, 4, 1, NULL),
(126, 'CÔNG NGHỆ THÔNG TIN 5', 'CD17TT5', 88, 4, 1, NULL),
(127, 'CÔNG NGHỆ THÔNG TIN 6', 'CD17TT6', 89, 4, 1, NULL),
(128, 'CÔNG NGHỆ THÔNG TIN 7', 'CD17TT7', 90, 4, 1, NULL),
(129, 'CÔNG NGHỆ THÔNG TIN 8', 'CD17TT8', 91, 4, 1, NULL),
(130, 'CÔNG NGHỆ THÔNG TIN 9', 'CD17TT9', 92, 4, 1, NULL),
(131, 'TRUYỀN THÔNG VÀ MẠNG MÁY TÍNH 1', 'CD17TM1', 93, 4, 2, NULL),
(132, 'TRUYỀN THÔNG VÀ MẠNG MÁY TÍNH 2', 'CD17TM2', 93, 4, 2, NULL),
(133, 'THIẾT KẾ ĐỒ HỌA 1', 'CD17ĐH1', 94, 4, 3, NULL),
(134, 'THIẾT KẾ ĐỒ HỌA 2', 'CD17ĐH2', 95, 4, 3, NULL),
(135, 'THIẾT KẾ ĐỒ HỌA 3', 'CD17ĐH3', 86, 4, 3, NULL),
(136, 'CÔNG NGHỆ THÔNG TIN 1', 'CD18TT1', 78, 1, 1, NULL),
(137, 'CÔNG NGHỆ THÔNG TIN 2', 'CD18TT2', 96, 1, 1, NULL),
(138, 'CÔNG NGHỆ THÔNG TIN 3', 'CD18TT3', 97, 1, 1, NULL),
(139, 'CÔNG NGHỆ THÔNG TIN 5', 'CD18TT5', 98, 1, 1, NULL),
(140, 'CÔNG NGHỆ THÔNG TIN 6', 'CD18TT6', 90, 1, 1, NULL),
(141, 'CÔNG NGHỆ THÔNG TIN 7', 'CD18TT7', 98, 1, 1, NULL),
(142, 'CÔNG NGHỆ THÔNG TIN 8', 'CD18TT8', 99, 1, 1, NULL),
(143, 'CÔNG NGHỆ THÔNG TIN 9', 'CD18TT9', 98, 1, 1, NULL),
(144, 'TRUYỀN THÔNG VÀ MẠNG MÁY TÍNH 1', 'CD18TM1', 84, 1, 2, NULL),
(145, 'TRUYỀN THÔNG VÀ MẠNG MÁY TÍNH 2', 'CD18TM2', 83, 1, 2, NULL),
(146, 'THIẾT KẾ ĐỒ HỌA 1', 'CD18ĐH1', 94, 1, 3, NULL),
(147, 'THIẾT KẾ ĐỒ HỌA 2', 'CD18ĐH2', 82, 1, 3, NULL),
(148, 'THIẾT KẾ ĐỒ HỌA 3', 'CD18ĐH3', 95, 1, 3, NULL),
(149, NULL, 'CD17TT4', 90, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(55) NOT NULL,
  `course_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_code`) VALUES
(1, 'CDCQ-K18', 'CDCQ-K18'),
(3, 'CDCQ-K16', 'CDCQ-K16'),
(4, 'CDCQ-K17', 'CDCQ-K17');

-- --------------------------------------------------------

--
-- Table structure for table `disciplinary_information`
--

CREATE TABLE `disciplinary_information` (
  `di_id` int(55) NOT NULL,
  `di_student_id` int(55) NOT NULL,
  `di_TBC` float DEFAULT NULL,
  `di_TCTL` float DEFAULT NULL,
  `di_TC_debt` float DEFAULT NULL,
  `di_TBCTL` float DEFAULT NULL,
  `di_DTB10` float DEFAULT NULL,
  `di_student_year` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `di_teacher_confirm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `di_falcuty_confirm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `di_discipline_id` int(55) DEFAULT NULL,
  `di_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `di_last_result` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `di_dicision` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `di_semester` int(2) NOT NULL,
  `di_year` int(5) NOT NULL,
  `di_admin_edit_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `di_admin_edit_time` timestamp NULL DEFAULT NULL,
  `di_delete` int(2) DEFAULT NULL COMMENT '0:hide 1:show',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discipline`
--

CREATE TABLE `discipline` (
  `discipline_id` int(55) NOT NULL,
  `discipline_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `discipline`
--

INSERT INTO `discipline` (`discipline_id`, `discipline_name`) VALUES
(2, 'Buộc Thôi Học'),
(8, 'Cảnh cáo'),
(9, 'Khiển trách'),
(10, 'Đình chỉ học tập 1 năm');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `major_id` int(55) NOT NULL,
  `major_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `major_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `major_symbol` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`major_id`, `major_name`, `major_code`, `major_symbol`) VALUES
(1, 'CÔNG NGHỆ THÔNG TIN', '123123123123', 'TT'),
(2, 'TRUYỀN THÔNG VÀ MẠNG MÁY TÍNH', 'TM', 'TM'),
(3, 'THIẾT KẾ ĐỒ HỌA', 'ĐH', 'ĐH');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(55) NOT NULL COMMENT 'chú ý: không được thay đổi Id',
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'superadmin:1 | admin:2 | user:3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'supperadmin'),
(2, 'admin (Khoa)'),
(3, 'user (GV/CVHT)');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(55) NOT NULL,
  `student_fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `student_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `student_contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_birth` int(255) DEFAULT NULL,
  `student_level_edu` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_type_edu` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_class_id` int(55) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_fullname`, `student_code`, `student_contact`, `student_birth`, `student_level_edu`, `student_type_edu`, `student_class_id`, `created_at`, `updated_at`) VALUES
(1307, '123123213213', '123123213213', NULL, 0, NULL, NULL, 113, '2019-05-10 17:03:24', '2019-05-10 17:03:24');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(55) NOT NULL,
  `teacher_fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `teacher_phone` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `teacher_email` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `teacher_fullname`, `teacher_code`, `teacher_phone`, `teacher_email`, `created_at`, `updated_at`) VALUES
(5, 'superadmin', 'superadmin', 'superadmin', 'superadmin', '2019-04-10 11:36:29', '2019-04-12 07:43:41'),
(77, 'Phan Thị Trinh', '7000000', NULL, NULL, '2019-05-10 05:18:22', '2019-05-10 05:18:22'),
(78, 'Phan Thị Trinh', '79000G07.000324', NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(79, 'Mai Kỷ Tuyên', '79000G07.000190', NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(80, 'Huỳnh Thị Phương Thủy', '79000G07.000322', NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(81, 'Nguyễn Thị Hồng Mỹ', '79000G07.000290', NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(82, 'Nguyễn Ngọc Cẩm Tú', '79000G07.000208', NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(83, 'Nguyễn Thị Mộng Hằng', '79000G07.000320', NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(84, 'Nguyễn Ngọc Ánh Mỹ', '79000G07.000321', NULL, NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(85, 'Nguyễn Thanh Vũ', '79000G07.000246', NULL, NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(86, 'Trần Thị Minh Sa', '70100G07.000014', NULL, NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(87, 'Phan Gia Phước', '79000G07.000319', NULL, NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(88, 'Nguyễn Huy Hoàng', '79000G07.000373', NULL, NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(89, 'Hoàng Công Trình', '79000G07.000325', NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(90, 'Ngô Minh Anh Thư', '79000G07.000151', NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(91, 'Bùi Thanh Yên Thảo', '79000G07.000450', NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(92, 'Bùi Thị Phương Thảo', '79000G07.000326', NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(93, 'Cao Trần Thái Anh', '79000G07.000127', NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(94, 'Nguyễn Phong Lan', '79000G07.000200', NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(95, 'Đoàn Quốc Thuận', '79000G07.000247', NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03'),
(96, 'Phan Thị Thể', '79000G07.000210', NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03'),
(97, 'Lâm Thị Phương Thảo', '70100G07.000015', NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03'),
(98, 'Võ Duy Tâm', '79000G07.000350', NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03'),
(99, 'Lê Thọ', '79000G07.000323', NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `user_teacher_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_role_id` int(55) NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `teacher_last_active` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_teacher_code`, `password`, `user_role_id`, `remember_token`, `teacher_last_active`, `created_at`, `updated_at`) VALUES
(65, 'superadmin', '$2y$10$zzUrQ7maDoYoA21QVEP.K.Hjc8Z3Mcnws1yjd0CgsRkVP2.H/mNfO', 1, 'MpTuEGUMFvh3KdpYnmEtNkj9mFY3jsFg40TbDwTAjTAY5a4AxkbTSU51M9Y6', NULL, '2019-05-07 00:31:09', '2019-05-10 01:50:17'),
(90, '7000000', '$2y$10$.PhYkwDg.dEcjYxwqQOpw.5h4w4BSP2jFVzMzMJvaeOW6j7C3BmUm', 3, NULL, NULL, '2019-05-10 05:18:22', '2019-05-10 05:18:22'),
(91, '79000G07.000324', '$2y$10$SiTmDqoY/cOh8qG/GAhuYut20endRe1rpHL.WZa.y9XodjApdMQ5i', 2, 'UXgZFMpPEpL9mToHvM8UqzIMUeNkq1i3OANLc5TP47S4kFxkgC7dQUfptgc6', NULL, '2019-05-10 10:16:00', '2019-05-10 13:57:27'),
(92, '79000G07.000190', '$2y$10$PjYo1.rI.bwkscsBX.OtHePqDT/TPRZLnl9Gc0CrCWWiKwNBRkRa2', 3, NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(93, '79000G07.000322', '$2y$10$cYENfylyKAPI1yiP59IRyOmb0IV7KGLTnTjF3XvxrkycYrPoIykpO', 3, NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(94, '79000G07.000290', '$2y$10$Uv0luG77Wj.5JqtPIa.kVui7Bu8F0yCfkOFBcx2Tt1jH2Cvbo5yaK', 3, 'AVycia1uWO4zwuiwPZNXAnSngi3gfXUZFel2QAiGaX1A5h9D1AhlBo75qMj7', NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(95, '79000G07.000208', '$2y$10$tTHcfVQC5U8zZVJtlJdx0OCh77KnTGpViqZkCmQj8ZZdRkPTjo9eK', 3, NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(96, '79000G07.000320', '$2y$10$1RkFDVyPtZIifBFseeO6bembhWCwhxrfcrGuifcKub0z4j6W8clOS', 3, NULL, NULL, '2019-05-10 10:16:00', '2019-05-10 10:16:00'),
(97, '79000G07.000321', '$2y$10$K251RN.FA2eBlr1AcdwTWudbjzqlfJIiPzJHvdENuAM5pIrkNJ9dG', 3, NULL, NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(98, '79000G07.000246', '$2y$10$y95fxnuWneNJotK70h6wY.x/0rYTwcpHGTXcuaIkvcviblRSQW0qm', 3, 'bZgmFRw0n7DGV6vOIcKA5RNMjvyuFmnsijT9MZB68j82Ju76mMHCA224HOJO', NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(99, '70100G07.000014', '$2y$10$XGBkHodp48KPhaPFea3kEeSn.2r9O6xSabKpA4RK67n4X8NGIIzJy', 3, NULL, NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(100, '79000G07.000319', '$2y$10$UaM3Lrz6VOcsf6NYFPqJKOkyQ8TppHxr7bZ4yO5sDTwpZZ.IgZEVG', 3, NULL, NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(101, '79000G07.000373', '$2y$10$wkDVxxDt7gErk6wDPCoFiuApJg7.MvcN7LTaq9hgx.Cd6n0eBT3jW', 3, NULL, NULL, '2019-05-10 10:16:01', '2019-05-10 10:16:01'),
(102, '79000G07.000325', '$2y$10$1Xzpr6zbJIjdSOzgq6lcR.1c5hOaUFYqzD1ReWsqM39yxz1dzBAj2', 3, NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(103, '79000G07.000151', '$2y$10$6lIrNr9mNkJI3Lh4x6UMLuuUvaj0JMb8oDRdXJaJt.nTY8wmYwKAm', 3, NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(104, '79000G07.000450', '$2y$10$YrtiFdRWPLP1TaHqXYX3ruYDlPba5uvAn5TccgtaYwxJK2QfuoHwO', 3, NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(105, '79000G07.000326', '$2y$10$Zzj3Zz6K6eJ9BWuw3gCT1ePWx405iWrcQE6Q0jIYQGrggbtxqpK0G', 3, NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(106, '79000G07.000127', '$2y$10$n/lRlmtUhD9cnnAaqy3Cb.LkK5up1uoqR6VxpONn2Nz/u0FD5yBGq', 3, NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(107, '79000G07.000200', '$2y$10$x7fbbT7Qwa/mCX1HyY4xmOYqK4U3.SWN5o9ug9ja.GqJLz3aAxNpS', 3, NULL, NULL, '2019-05-10 10:16:02', '2019-05-10 10:16:02'),
(108, '79000G07.000247', '$2y$10$.SUIPfGfdheVcHDiGQd3quODDJtm64Ofh3kC96xFiX0jG3VJwE9ie', 3, NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03'),
(109, '79000G07.000210', '$2y$10$YG7Z3vHGpKnhHNna0Foveedvnb8r/mw0O6HEG0NulM92XezwTqThe', 3, NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03'),
(110, '70100G07.000015', '$2y$10$oSO1eP1eNO1Uagg9G3IgHOaUvm7pJWEPoc11.eSPX7Va.Ct5bWw1a', 3, NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03'),
(111, '79000G07.000350', '$2y$10$dbp/fUve7.p9AhxJDMvzu.TijRHc8qnfsU/LpNJsC56HgQNUrbc7i', 3, NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03'),
(112, '79000G07.000323', '$2y$10$l6LPf5qmHM9wXp2Z6Zzmse8ogj05BhJC4xdOSmzo/1ZM5gfzQRyEe', 3, NULL, NULL, '2019-05-10 10:16:03', '2019-05-10 10:16:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absent_information`
--
ALTER TABLE `absent_information`
  ADD PRIMARY KEY (`ai_id`),
  ADD KEY `fk_ab_st` (`ai_student_id`),
  ADD KEY `fk_ab_d` (`ai_discipline_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `fk_class_course` (`class_course_id`),
  ADD KEY `fk_class_teacher` (`class_teacher_id`),
  ADD KEY `fk_class_old_teacher` (`class_old_teacher_id`),
  ADD KEY `fk_cl_mj` (`class_major_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `disciplinary_information`
--
ALTER TABLE `disciplinary_information`
  ADD PRIMARY KEY (`di_id`),
  ADD KEY `fk_di_discipline` (`di_discipline_id`),
  ADD KEY `fk_di_student` (`di_student_id`);

--
-- Indexes for table `discipline`
--
ALTER TABLE `discipline`
  ADD PRIMARY KEY (`discipline_id`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`major_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_cl_st` (`student_class_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_u_role` (`user_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absent_information`
--
ALTER TABLE `absent_information`
  MODIFY `ai_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1384;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `disciplinary_information`
--
ALTER TABLE `disciplinary_information`
  MODIFY `di_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2287;
--
-- AUTO_INCREMENT for table `discipline`
--
ALTER TABLE `discipline`
  MODIFY `discipline_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `major_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(55) NOT NULL AUTO_INCREMENT COMMENT 'chú ý: không được thay đổi Id', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1308;
--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `absent_information`
--
ALTER TABLE `absent_information`
  ADD CONSTRAINT `fk_ab_d` FOREIGN KEY (`ai_discipline_id`) REFERENCES `discipline` (`discipline_id`),
  ADD CONSTRAINT `fk_ab_st` FOREIGN KEY (`ai_student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `fk_cl_mj` FOREIGN KEY (`class_major_id`) REFERENCES `major` (`major_id`),
  ADD CONSTRAINT `fk_class_course` FOREIGN KEY (`class_course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `fk_class_old_teacher` FOREIGN KEY (`class_old_teacher_id`) REFERENCES `teacher` (`teacher_id`),
  ADD CONSTRAINT `fk_class_teacher` FOREIGN KEY (`class_teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `disciplinary_information`
--
ALTER TABLE `disciplinary_information`
  ADD CONSTRAINT `fk_di_discipline` FOREIGN KEY (`di_discipline_id`) REFERENCES `discipline` (`discipline_id`),
  ADD CONSTRAINT `fk_di_student` FOREIGN KEY (`di_student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_cl_st` FOREIGN KEY (`student_class_id`) REFERENCES `class` (`class_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_u_role` FOREIGN KEY (`user_role_id`) REFERENCES `role` (`role_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
