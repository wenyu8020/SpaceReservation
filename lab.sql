-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-05-12 12:43:34
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `lab`
--

-- --------------------------------------------------------

--
-- 資料表結構 `reservation`
--

CREATE TABLE `reservation` (
  `resv_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `period` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `reservation`
--

INSERT INTO `reservation` (`resv_id`, `seat_id`, `username`, `date`, `start_time`, `end_time`, `period`) VALUES
(38, 7, 'M123040016', '2024-05-13', '08:00:00', '09:00:00', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `seat`
--

CREATE TABLE `seat` (
  `seat_id` int(11) NOT NULL,
  `seat_num` int(11) NOT NULL,
  `date` date NOT NULL,
  `socket` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `seat`
--

INSERT INTO `seat` (`seat_id`, `seat_num`, `date`, `socket`, `status`) VALUES
(1, 1, '2024-05-07', 1, 1),
(2, 2, '2024-05-07', 0, 1),
(3, 1, '2024-05-08', 1, 0),
(4, 1, '2024-05-12', 1, 0),
(5, 1, '2024-05-11', 1, 1),
(6, 2, '2024-05-11', 0, 1),
(7, 1, '2024-05-13', 1, 1),
(8, 2, '2024-05-13', 1, 1),
(9, 3, '2024-05-13', 0, 1),
(10, 4, '2024-05-13', 1, 0),
(11, 1, '2024-05-14', 1, 1),
(12, 2, '2024-05-14', 1, 1),
(13, 3, '2024-05-14', 0, 1),
(14, 4, '2024-05-14', 1, 1),
(15, 5, '2024-05-14', 0, 1),
(16, 6, '2024-05-14', 1, 0),
(17, 7, '2024-05-14', 1, 0),
(18, 8, '2024-05-14', 0, 1),
(19, 9, '2024-05-14', 1, 1),
(20, 10, '2024-05-14', 1, 1),
(21, 11, '2024-05-14', 1, 1),
(22, 12, '2024-05-14', 1, 1),
(23, 13, '2024-05-14', 1, 1),
(24, 14, '2024-05-14', 0, 1),
(25, 15, '2024-05-14', 1, 1),
(26, 1, '2024-05-15', 1, 1),
(27, 2, '2024-05-15', 1, 1),
(28, 3, '2024-05-15', 0, 1),
(29, 4, '2024-05-15', 1, 1),
(30, 5, '2024-05-15', 1, 1),
(31, 6, '2024-05-15', 0, 0),
(32, 7, '2024-05-15', 1, 0),
(33, 8, '2024-05-15', 0, 1),
(34, 9, '2024-05-15', 1, 1),
(35, 10, '2024-05-15', 1, 1),
(36, 11, '2024-05-15', 1, 1),
(37, 12, '2024-05-15', 1, 1),
(38, 13, '2024-05-15', 1, 1),
(39, 14, '2024-05-15', 1, 1),
(40, 15, '2024-05-15', 0, 1),
(41, 1, '2024-05-16', 1, 1),
(42, 2, '2024-05-16', 1, 1),
(43, 3, '2024-05-16', 0, 1),
(44, 4, '2024-05-16', 1, 1),
(45, 5, '2024-05-16', 0, 1),
(46, 6, '2024-05-16', 1, 0),
(47, 7, '2024-05-16', 1, 0),
(48, 8, '2024-05-16', 0, 1),
(49, 9, '2024-05-16', 1, 1),
(50, 10, '2024-05-16', 1, 1),
(51, 11, '2024-05-16', 1, 1),
(52, 12, '2024-05-16', 1, 1),
(53, 13, '2024-05-16', 1, 1),
(54, 14, '2024-05-16', 0, 1),
(55, 15, '2024-05-16', 1, 1),
(56, 1, '2024-05-17', 1, 1),
(57, 2, '2024-05-17', 1, 1),
(58, 3, '2024-05-17', 0, 1),
(59, 4, '2024-05-17', 1, 1),
(60, 5, '2024-05-17', 1, 1),
(61, 6, '2024-05-17', 0, 0),
(62, 7, '2024-05-17', 1, 0),
(63, 8, '2024-05-17', 0, 1),
(64, 9, '2024-05-17', 1, 1),
(65, 10, '2024-05-17', 1, 1),
(66, 11, '2024-05-17', 1, 1),
(67, 12, '2024-05-17', 1, 1),
(68, 13, '2024-05-17', 1, 1),
(69, 14, '2024-05-17', 1, 1),
(70, 15, '2024-05-17', 0, 1),
(71, 1, '2024-05-18', 0, 1),
(72, 2, '2024-05-18', 1, 1),
(73, 3, '2024-05-18', 0, 1),
(74, 4, '2024-05-18', 1, 1),
(75, 5, '2024-05-18', 1, 1),
(76, 6, '2024-05-18', 0, 1),
(77, 7, '2024-05-18', 1, 0),
(78, 8, '2024-05-18', 0, 1),
(79, 9, '2024-05-18', 1, 1),
(80, 10, '2024-05-18', 1, 1),
(81, 11, '2024-05-18', 1, 1),
(82, 12, '2024-05-18', 1, 1),
(83, 13, '2024-05-18', 1, 1),
(84, 14, '2024-05-18', 1, 1),
(85, 15, '2024-05-18', 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `uadate`
--

CREATE TABLE `uadate` (
  `uadate_id` int(11) NOT NULL,
  `uadate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `username` varchar(10) NOT NULL,
  `name` text NOT NULL,
  `role` enum('User','Administrator','','') NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`username`, `name`, `role`, `password`, `email`) VALUES
('admin', '管理員', 'Administrator', '$2y$10$oiomdfQbOls56SjeMSzO9u5Iw3iDQWW95QWnpXenRdZAI9e1c2hcy', 'sandy3809@gmail.com'),
('M123040016', '張紋瑜', 'User', '$2y$10$0R21KV6UeezrgVGqzIgsWeexoc3OdTcUYCcSMYVex2cmyIcRPjx/y', 'latinfish0208@gmail.com');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`resv_id`),
  ADD UNIQUE KEY `resv_id` (`resv_id`);

--
-- 資料表索引 `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seat_id`),
  ADD UNIQUE KEY `seat_id` (`seat_id`);

--
-- 資料表索引 `uadate`
--
ALTER TABLE `uadate`
  ADD PRIMARY KEY (`uadate_id`),
  ADD UNIQUE KEY `uadate_id` (`uadate_id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `reservation`
--
ALTER TABLE `reservation`
  MODIFY `resv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `seat`
--
ALTER TABLE `seat`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `uadate`
--
ALTER TABLE `uadate`
  MODIFY `uadate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
