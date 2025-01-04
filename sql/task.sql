-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 05:31 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskcalendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `task_title` varchar(50) NOT NULL,
  `task_description` varchar(255) DEFAULT NULL,
  `task_startdate` datetime NOT NULL,
  `task_duedatetime` datetime DEFAULT NULL,
  `task_status` varchar(5) NOT NULL DEFAULT 'to-do',
  `task_reminder` tinyint(1) NOT NULL DEFAULT 0,
  `task_date_created` date NOT NULL DEFAULT current_timestamp(),
  `task_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `task`
--
DELIMITER $$
CREATE TRIGGER `trg_TASK_DELETE` AFTER DELETE ON `task` FOR EACH ROW INSERT INTO task_log (task_id, operation)
VALUES (OLD.task_id, 'DELETE')
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_TASK_INSERT` AFTER INSERT ON `task` FOR EACH ROW INSERT INTO task_log(task_id, operation, modifieddate)
VALUES (NEW.task_id,'INSERT',NOW())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_TASK_UPDATE` AFTER UPDATE ON `task` FOR EACH ROW INSERT INTO task_log (task_id, operation)
VALUES (NEW.task_id,'UPDATE')
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `fk_task_user_idn` (`task_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk_task_user_idn` FOREIGN KEY (`task_user_id`) REFERENCES `user_info` (`user_idn`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
