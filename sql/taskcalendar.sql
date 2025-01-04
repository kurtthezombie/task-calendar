-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 05:09 AM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_createTask` (IN `var_task_title` VARCHAR(50), IN `var_task_description` VARCHAR(255), IN `var_task_startdate` DATETIME, IN `var_task_duedatetime` DATETIME, IN `var_task_status` VARCHAR(5), IN `var_task_reminders` TINYINT(1), IN `owner_id` INT)   BEGIN
    INSERT INTO task (
        task_title,
        task_description,
        task_startdate,
        task_duedatetime,
        task_status,
        task_reminder,
        task_date_created,
        task_user_id
    )
    VALUES (
        var_task_title,
        var_task_description,
        var_task_startdate,
        var_task_duedatetime,
        var_task_status,
        var_task_reminders,
        NOW(),
        owner_id
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_createUser` (IN `var_email` VARCHAR(25), IN `var_password` VARCHAR(100), IN `var_firstname` VARCHAR(25), IN `var_lastname` VARCHAR(15))   BEGIN
    INSERT INTO user_info (user_email, user_password, user_fname, user_lname)
    VALUES (var_email, var_password, var_firstname, var_lastname);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_deleteTask` (IN `taskid_param` INT(11))   BEGIN
    DELETE FROM `task` WHERE `task_id` = taskid_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_deleteUser` (IN `param_id` INT)   BEGIN
    DELETE
    FROM user_info
    WHERE user_idn = param_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getTasksByUsers` (IN `email_param` VARCHAR(25))   BEGIN
    SELECT * FROM task t
	INNER JOIN user_info u on u.user_idn = t.task_user_id
	WHERE user_email = email_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getUser` (IN `firstname_param` VARCHAR(25), IN `lastname_param` VARCHAR(15))   BEGIN
    SELECT * FROM user_info
    WHERE user_fname = firstname_param AND user_lname = lastname_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateTask` (IN `var_task_id` INT, IN `var_task_title` VARCHAR(50), IN `var_task_description` VARCHAR(255), IN `var_task_startdate` DATETIME, IN `var_task_duedatetime` DATETIME, IN `var_task_status` VARCHAR(5), IN `var_task_reminder` TINYINT(1))   BEGIN
    UPDATE task
    SET
        task_title = var_task_title,
        task_description = var_task_description,
        task_startdate = var_task_startdate,
        task_duedatetime = var_task_duedatetime,
        task_status = var_task_status,
        task_reminder = var_task_reminder
    WHERE task_id = var_task_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateUser` (IN `param_id` INT, IN `param_password` VARCHAR(100), IN `param_fname` VARCHAR(25), IN `param_lname` VARCHAR(15))   BEGIN
    UPDATE user_info
    SET user_fname = param_fname,
    user_lname = param_lname,
    user_password = param_password
    WHERE user_idn = param_id;
END$$

DELIMITER ;

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
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_title`, `task_description`, `task_startdate`, `task_duedatetime`, `task_status`, `task_reminder`, `task_date_created`, `task_user_id`) VALUES
(11, 'Lorep Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In non diam vel orci gravida consequat vel sed elit. Mauris non sapien quis sapien euismod molestie vitae nec quam.', '2023-12-15 15:03:00', '2023-12-16 12:18:00', 'to-do', 1, '2023-12-15', 1),
(36, 'PHP moneyapp', '- Refine the moneyapp php activity.', '2023-12-16 10:30:00', '2023-12-16 15:30:00', 'to-do', 0, '2023-12-16', 2),
(40, 'SportsStore', 'Read the pdf about SportsStore and do what is told.', '2023-12-17 00:00:00', '2023-12-17 23:59:00', 'done', 0, '2023-12-16', 2),
(41, 'Literature Final Act', 'Make a history of literature, encode, submit by monday.', '2023-12-18 08:30:00', '2023-12-18 09:30:00', 'to-do', 1, '2023-12-16', 2),
(42, 'Literature: Performance Task Finals', 'Create an interview video of an author.', '2023-12-19 08:30:00', '2023-12-22 09:30:00', 'to-do', 0, '2023-12-16', 2),
(43, 'Christmas Break', 'Take a break, enjoy the season, and open gifts! This task is a reminder to embrace the festive spirit and relax during the Christmas break. No specific actions required – just savor the holiday moments!', '2023-12-23 00:00:00', '2023-12-26 23:59:00', 'to-do', 0, '2023-12-16', 2),
(44, 'Study Fullcalendar.i', 'Study the functions of this package in order to render a calendar', '2023-12-10 09:00:00', '2023-12-13 21:00:00', 'done', 0, '2023-12-16', 1),
(45, 'Render Calendar', 'Render the calendar and proceed to adding functions', '2023-12-11 00:00:00', '0000-00-00 00:00:00', 'to-do', 0, '2023-12-16', 1),
(46, 'Create task modal', 'The most important modal for the C in our CRUD', '2023-12-12 00:00:00', '0000-00-00 00:00:00', 'to-do', 1, '2023-12-16', 1),
(50, 'Defense of the ancient', 'Defend the ancient inventory system.', '2023-12-18 00:00:00', '0000-00-00 00:00:00', 'to-do', 1, '2023-12-17', 28);

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

-- --------------------------------------------------------

--
-- Table structure for table `task_log`
--

CREATE TABLE `task_log` (
  `logid` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `operation` varchar(15) NOT NULL,
  `modifieddate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_log`
--

INSERT INTO `task_log` (`logid`, `task_id`, `operation`, `modifieddate`) VALUES
(1, 40, 'UPDATE', '2023-12-17 11:39:07'),
(2, 47, 'INSERT', '2023-12-17 12:01:31'),
(3, 47, 'UPDATE', '2023-12-17 12:01:44'),
(4, 47, 'DELETE', '2023-12-17 12:02:06'),
(5, 48, 'INSERT', '2023-12-17 12:07:51'),
(6, 48, 'UPDATE', '2023-12-17 16:35:31'),
(7, 48, 'UPDATE', '2023-12-17 16:35:56'),
(8, 49, 'INSERT', '2023-12-17 16:36:42'),
(9, 49, 'UPDATE', '2023-12-17 16:37:13'),
(10, 49, 'UPDATE', '2023-12-17 16:37:23'),
(11, 49, 'DELETE', '2023-12-17 16:37:45'),
(12, 48, 'DELETE', '2023-12-17 16:37:48'),
(13, 50, 'INSERT', '2023-12-17 23:05:22'),
(14, 51, 'INSERT', '2023-12-17 23:33:10'),
(15, 51, 'UPDATE', '2023-12-17 23:33:22'),
(16, 51, 'DELETE', '2023-12-17 23:33:26'),
(17, 42, 'UPDATE', '2023-12-17 23:33:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_idn` int(11) NOT NULL,
  `user_email` varchar(25) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_fname` varchar(25) NOT NULL,
  `user_lname` varchar(15) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_idn`, `user_email`, `user_password`, `user_fname`, `user_lname`, `date_created`) VALUES
(1, 'admin@t.c', '$2y$10$/GsT7t3SpatVoV0LPIhhqep3KkGKCkKWOtCzkvo03iB9tZ9SgU.qi', 'Admini', 'Strator', '2023-12-03 09:55:28'),
(2, 'kurt@t.c', '$2y$10$BkGodsUq3O24ruPIY0ouNekKc0o/NobdVPg46PtoOnh5pkiFX.5Iq', 'Kurt', 'Cabaluna', '2023-12-15 11:23:28'),
(27, 'bigdaddy@t.c', '$2y$10$MKAThRVbPdjkMih/FFKXqO/lAYGcvebNPeGaVTr6N0jZL6qRX6.NG', 'Johann', 'Sundstein', '2023-12-17 16:20:15'),
(28, 'rian@t.c', '$2y$10$W8OXzcnSk1CEDUOSlDIz7u.oUBumt2D3AV2iSxOqZFAeA/8ba9Lie', 'Rian', 'Canoy', '2023-12-17 16:20:23'),
(30, 'dummy@t.c', '$2y$10$xtFja9PAn.JzML37099jZOvUz65d.WZYBqMGHWOT9qwHPf9MYKpZG', 'Mark', 'Wiens', '2023-12-17 19:38:14');

--
-- Triggers `user_info`
--
DELIMITER $$
CREATE TRIGGER `trg_USER_DELETE` AFTER DELETE ON `user_info` FOR EACH ROW INSERT INTO user_log(user_idn,operation)
VALUES (OLD.user_idn,'DELETE')
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_USER_INSERT` AFTER INSERT ON `user_info` FOR EACH ROW INSERT INTO user_log(user_idn,operation)
VALUES (NEW.user_idn,'INSERT')
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_USER_UPDATE` AFTER UPDATE ON `user_info` FOR EACH ROW INSERT INTO user_log (user_idn, operation)
VALUES (NEW.user_idn, 'UPDATE')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `logid` int(11) NOT NULL,
  `user_idn` int(11) NOT NULL,
  `operation` varchar(15) NOT NULL,
  `modifieddate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`logid`, `user_idn`, `operation`, `modifieddate`) VALUES
(1, 29, 'UPDATE', '2023-12-17 19:36:56'),
(2, 29, 'DELETE', '2023-12-17 19:37:30'),
(3, 30, 'INSERT', '2023-12-17 19:38:14'),
(4, 28, 'UPDATE', '2023-12-17 23:06:19'),
(5, 27, 'UPDATE', '2023-12-18 10:31:39');

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
-- Indexes for table `task_log`
--
ALTER TABLE `task_log`
  ADD PRIMARY KEY (`logid`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_idn`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`logid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `task_log`
--
ALTER TABLE `task_log`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_idn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
