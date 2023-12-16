-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 02:35 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_createTask` (IN `var_task_title` VARCHAR(20), IN `var_task_description` VARCHAR(255), IN `var_task_startdate` DATETIME, IN `var_task_duedatetime` DATETIME, IN `var_task_status` VARCHAR(5), IN `var_task_reminders` TINYINT(1), IN `owner_id` INT)   BEGIN
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getUser` (IN `firstname_param` VARCHAR(25), IN `lastname_param` VARCHAR(15))   BEGIN
    SELECT * FROM user_info
    WHERE user_fname = firstname_param AND user_lname = lastname_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateTask` (IN `var_task_id` INT, IN `var_task_title` VARCHAR(20), IN `var_task_description` VARCHAR(255), IN `var_task_startdate` DATETIME, IN `var_task_duedatetime` DATETIME, IN `var_task_status` VARCHAR(5), IN `var_task_reminder` TINYINT(1))   BEGIN
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

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `task_title` varchar(20) NOT NULL,
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
(40, 'SportsStore', 'I already submitted the SportsStore LMAO', '2023-12-17 00:00:00', '2023-12-17 23:59:00', 'done', 0, '2023-12-16', 2),
(41, 'Literature Final Act', 'Make a history of literature, encode, submit by monday.', '2023-12-18 08:30:00', '2023-12-18 09:30:00', 'to-do', 1, '2023-12-16', 2),
(42, 'Literature: Performa', 'Create an interview video of an author.', '2023-12-19 08:30:00', '2023-12-22 09:30:00', 'to-do', 0, '2023-12-16', 2),
(43, 'Christmas Break', 'Take a break, enjoy the season, and open gifts! This task is a reminder to embrace the festive spirit and relax during the Christmas break. No specific actions required – just savor the holiday moments!', '2023-12-23 00:00:00', '2023-12-26 23:59:00', 'to-do', 0, '2023-12-16', 2),
(44, 'Study Fullcalendar.i', 'Study the functions of this package in order to render a calendar', '2023-12-10 09:00:00', '2023-12-13 21:00:00', 'done', 0, '2023-12-16', 1),
(45, 'Render Calendar', 'Render the calendar and proceed to adding functions', '2023-12-11 00:00:00', '0000-00-00 00:00:00', 'to-do', 0, '2023-12-16', 1),
(46, 'Create task modal', 'The most important modal for the C in our CRUD', '2023-12-12 00:00:00', '0000-00-00 00:00:00', 'to-do', 1, '2023-12-16', 1);

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
(2, 'kurt@t.c', '$2y$10$BkGodsUq3O24ruPIY0ouNekKc0o/NobdVPg46PtoOnh5pkiFX.5Iq', 'Kurt', 'Cabaluna', '2023-12-15 11:23:28');

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
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_idn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_idn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
