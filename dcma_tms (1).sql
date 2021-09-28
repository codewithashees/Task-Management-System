-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2021 at 12:51 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dcma_tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_number` varchar(50) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `client_company` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_number`, `project_name`, `client_company`, `start_date`, `end_date`, `status`, `description`, `datetime`) VALUES
(2, 'DCMA-P0000002', 'Stock Management System', 'The Refrigeration House', '2021-08-23', '2021-09-30', 'Open', '																																				&lt;ol&gt;&lt;li&gt;&lt;b&gt;Man&lt;/b&gt;&lt;/li&gt;&lt;li&gt;&lt;b&gt;Women&lt;/b&gt;&lt;/li&gt;&lt;li&gt;&lt;b&gt;jssss&lt;/b&gt;&lt;/li&gt;&lt;/ol&gt;										', '2021-08-20 17:38:21'),
(9, 'DCMA-P0000003', 'TRH Sales', 'TRH The Ref House', '2021-08-28', '2021-08-29', 'Open', '						&lt;ol&gt;&lt;li&gt;ajk&lt;/li&gt;&lt;/ol&gt;					', '2021-08-27 11:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `task_no` varchar(50) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_file` text NOT NULL,
  `assigned` varchar(100) NOT NULL,
  `task_description` text NOT NULL,
  `task_priority` varchar(100) NOT NULL,
  `task_status` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `user_id`, `project_id`, `project_name`, `task_no`, `task_name`, `task_file`, `assigned`, `task_description`, `task_priority`, `task_status`, `datetime`) VALUES
(26, 5, 0, '', 'DCMA-T0000026', 'xyz', '', '5/Arpit', 'asdasda', 'Medium', 'Canceled', '2021-08-21 23:30:01'),
(27, 3, 2, '', 'DCMA-T0000027', 'sadasdsadasdasdsadsa', '', '3/Pankaj', 'sdsadsadasd', 'High', 'Canceled', '2021-08-21 23:32:02'),
(28, 2, 0, '', 'DCMA-T0000028', 'sdasdsa', '', '2/Mayank', 'sadd', 'Low', 'Completed', '2021-08-21 23:35:52'),
(29, 2, 2, '', 'DCMA-T0000029', 'Task2', '', '2/Mayank', 's', 'Medium', 'Canceled', '2021-08-21 23:37:28'),
(30, 2, 0, '', 'DCMA-T0000030', 'ABC', '', '2/Mayank', 'DIS', 'High', 'Pending', '2021-08-27 10:29:25'),
(31, 5, 2, '', 'DCMA-T0000031', 'sdsfdsfds', '', '5/Arpit', 'dvdCD', 'Urgent', 'Pending', '2021-08-27 10:58:13'),
(32, 2, 9, '', 'DCMA-T0000032', 'ssd', '', '2/Mayank', 'sdsds', 'High', 'Canceled', '2021-08-27 11:01:02'),
(33, 2, 2, '', 'DCMA-T0000033', 'Update Task', '', '2/Mayank', 'DCMA Website', 'Medium', 'Canceled', '2021-08-28 14:09:35'),
(37, 2, 0, '', 'DCMA-T0000034', 'sadfsg', 'upload_files/.Poster.jpeg', '2/Mayank', 'dfasdsgf', 'Urgent', 'Canceled', '2021-08-30 23:19:35'),
(38, 2, 0, '', 'DCMA-T0000038', 'adsddfd', 'upload_files/Poster.jpeg', '2/Mayank', 'dafsd', 'Medium', 'Canceled', '2021-08-30 23:26:54'),
(41, 7, 0, 'Self', 'DCMA-T0000041', 'Testing PDO', 'upload_files/WhatsApp Image 2021-08-31 at 15.42.07 (1).jpeg', '7/Amit', '&lt;p&gt;Testing PDO&lt;/p&gt;', 'High', 'Canceled', '2021-09-01 13:59:26');

-- --------------------------------------------------------

--
-- Table structure for table `task_activity`
--

CREATE TABLE `task_activity` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `task_no` varchar(100) NOT NULL,
  `task_name` varchar(100) NOT NULL,
  `u_taskname` varchar(100) NOT NULL,
  `assign_to` varchar(100) NOT NULL,
  `u_assignto` varchar(100) NOT NULL,
  `task_priority` varchar(100) NOT NULL,
  `u_priority` varchar(100) NOT NULL,
  `task_status` varchar(100) NOT NULL,
  `u_status` varchar(100) NOT NULL,
  `task_update_note` text NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_activity`
--

INSERT INTO `task_activity` (`id`, `user_name`, `task_no`, `task_name`, `u_taskname`, `assign_to`, `u_assignto`, `task_priority`, `u_priority`, `task_status`, `u_status`, `task_update_note`, `datetime`) VALUES
(4, 'Ashees', 'DCMA-T0000033', 'Test2', 'Test2', '3/Pankaj', '2/Mayank', 'Low', 'Low', 'Pending', 'Pending', 'Change Assignee', '2021-08-30 15:43:31'),
(5, 'Ashees', 'DCMA-T0000033', 'Test2', 'Update Task Name', '2/Mayank', '2/Mayank', 'Low', 'Medium', 'Pending', 'Canceled', 'Change Name Priority and Task Status...', '2021-08-30 16:05:09'),
(6, 'Ashees', 'DCMA-T0000033', 'Update Task Name', 'Update Task', '2/Mayank', '2/Mayank', 'Medium', 'Medium', 'Canceled', 'Canceled', '', '2021-08-30 19:58:48'),
(7, 'Ashees', 'DCMA-T0000033', 'Update Task', 'Update Task', '2/Mayank', '2/Mayank', 'Medium', 'Medium', 'Canceled', 'Pending', 'change status', '2021-08-30 20:36:22'),
(8, 'Ashees', 'DCMA-T0000041', 'Testing PDO', 'Testing PDO', '8/Adesh', '8/Adesh', 'High', 'High', 'Canceled', 'Canceled', '', '2021-09-01 22:17:05'),
(9, 'Ashees', 'DCMA-T0000041', 'Testing PDO', 'Testing PDO', '8/Adesh', '8/Adesh', 'High', 'Urgent', 'Canceled', 'Canceled', '', '2021-09-01 22:19:27'),
(10, 'Ashees', 'DCMA-T0000041', 'Testing PDO', 'Testing PDO', '8/Adesh', '8/Adesh', 'Urgent', 'Urgent', 'Canceled', 'Canceled', '', '2021-09-01 22:19:37'),
(11, 'Ashees', 'DCMA-T0000041', 'Testing PDO', 'Testing PDO', '8/Adesh', '8/Adesh', 'Urgent', 'High', 'Canceled', 'Canceled', '', '2021-09-01 22:20:24'),
(12, 'Ashees', 'DCMA-T0000041', 'Testing PDO', 'Testing PDO', '8/Adesh', '8/Adesh', 'High', 'High', 'Canceled', 'Completed', '', '2021-09-01 22:20:49'),
(13, 'Ashees', 'DCMA-T0000041', 'Testing PDO', 'Testing PDO', '8/Adesh', '8/Adesh', 'High', 'High', 'Completed', 'Pending', '', '2021-09-01 22:21:28'),
(14, 'Ashees', 'DCMA-T0000041', 'Testing PDO', 'Testing PDO', '8/Adesh', '8/Adesh', 'High', 'High', 'Pending', 'Canceled', '', '2021-09-01 22:21:47'),
(15, 'Ashees', 'DCMA-T0000041', 'Testing PDO', 'Testing PDO', '8/Adesh', '7/Amit', 'High', 'High', 'Canceled', 'Canceled', '', '2021-09-01 22:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `todo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_name` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `priority` varchar(100) NOT NULL,
  `due_date` date NOT NULL,
  `notes` text NOT NULL,
  `css_class` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`todo_id`, `user_id`, `task_name`, `status`, `priority`, `due_date`, `notes`, `css_class`, `datetime`) VALUES
(1, 2, 'P Management', 'Pending', 'Medium', '2021-08-24', 'nothing', '', '2021-08-24 10:33:42'),
(2, 2, 'Need to Work on WFM', 'Completed', 'Medium', '2021-08-24', 'undefined', 'done', '2021-08-24 10:47:29'),
(5, 2, 'P Management', 'Completed', 'Medium', '2021-08-24', 'Nothing', 'done', '2021-08-24 12:54:34'),
(6, 2, 'Today Tsk', 'Completed', 'Low', '2021-08-24', 'Noc', 'done', '2021-08-24 12:56:42'),
(8, 1, 'Testing final PDO', 'Completed', 'High', '2021-09-01', 'Done Now, this is secure from SQL Injection...', '', '2021-09-02 00:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password`, `role`, `status`) VALUES
(1, 'Ashees', 'Vishwakarma', 'vashees@dcmatechnologies.com', 'password', 'admin', 1),
(2, 'Mayank', 'Dhama', 'mdhama@dcmatechnologies.com', 'password', 'user', 1),
(3, 'Pankaj', 'Wadhawan', 'wpankaj@dcmatechnologies.com', 'password', 'user', 1),
(5, 'Arpit', 'Developer', 'arpit@dcmatechnologies.com', 'password', 'user', 1),
(7, 'Amit', 'Sharma', 'amit@gmail.com', 'password', 'user', 1),
(9, 'user 2', 'User 2', 'User@dcmatechnologies.com', '239273213', 'user', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_productivity`
--

CREATE TABLE `user_productivity` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_no` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_productivity`
--

INSERT INTO `user_productivity` (`id`, `user_name`, `project_id`, `task_no`, `date`, `start_time`, `end_time`, `description`) VALUES
(5, 'Ashees', 2, 'DCMA-T0000027', '2021-08-29', '20:54:00', '23:22:00', 'Im working on Project productivity. Almost its completed just testing username and all is showing in productivity or not.'),
(6, 'Ashees', 2, 'DCMA-T0000029', '2021-08-30', '00:46:00', '12:44:00', 'ffgfgfg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `task_activity`
--
ALTER TABLE `task_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`todo_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_productivity`
--
ALTER TABLE `user_productivity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `task_activity`
--
ALTER TABLE `task_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_productivity`
--
ALTER TABLE `user_productivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
