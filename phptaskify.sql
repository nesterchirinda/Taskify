-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2024 at 03:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phptaskify`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_admins`
--

CREATE TABLE `group_admins` (
  `groupId` int(11) NOT NULL,
  `usersId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_admins`
--

INSERT INTO `group_admins` (`groupId`, `usersId`, `teamId`) VALUES
(7, 59, 19);

-- --------------------------------------------------------

--
-- Table structure for table `group_tasks`
--

CREATE TABLE `group_tasks` (
  `groupTaskId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `groupTaskName` varchar(255) NOT NULL,
  `groupTaskDescription` text DEFAULT NULL,
  `groupTaskDeadline` date DEFAULT NULL,
  `groupTaskPriority` enum('Low','Medium','High') DEFAULT NULL,
  `groupTaskStatus` enum('Not Started','In Progress','Done') DEFAULT 'Not Started',
  `IsImportant` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_tasks`
--

INSERT INTO `group_tasks` (`groupTaskId`, `teamId`, `groupTaskName`, `groupTaskDescription`, `groupTaskDeadline`, `groupTaskPriority`, `groupTaskStatus`, `IsImportant`) VALUES
(2, 19, 'Update UI to fit Alex\'s design', 'Complete taskify app, reflective account & portfolio.', '2024-05-02', 'Medium', 'Not Started', 1),
(12, 19, 'Test', 'testing group task 2', '2024-05-02', NULL, 'Not Started', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationId` int(11) NOT NULL,
  `usersId` int(11) NOT NULL,
  `notificationType` varchar(50) DEFAULT NULL,
  `notificationContent` text NOT NULL,
  `notificationTimeStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shared_lists`
--

CREATE TABLE `shared_lists` (
  `sharedListId` int(11) NOT NULL,
  `taskListId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_tasks`
--

CREATE TABLE `sub_tasks` (
  `subTaskId` int(11) NOT NULL,
  `taskId` int(11) DEFAULT 0,
  `subTaskName` varchar(128) DEFAULT NULL,
  `isDone` tinyint(1) DEFAULT 0,
  `groupTaskId` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `taskId` int(11) NOT NULL,
  `taskListId` int(11) DEFAULT NULL,
  `taskName` varchar(128) NOT NULL,
  `taskDescription` text DEFAULT NULL,
  `taskDeadline` date DEFAULT NULL,
  `taskPriority` enum('Low','Medium','High') DEFAULT NULL,
  `taskStatus` enum('Not Started','In Progress','Done') NOT NULL DEFAULT 'Not Started',
  `IsImportant` tinyint(1) DEFAULT NULL,
  `usersId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskId`, `taskListId`, `taskName`, `taskDescription`, `taskDeadline`, `taskPriority`, `taskStatus`, `IsImportant`, `usersId`) VALUES
(2, NULL, 'Test', 'testing', '2024-05-11', 'Medium', 'Not Started', 0, NULL),
(3, NULL, 'Test', 'testing', '2024-05-11', 'Medium', 'Not Started', 0, NULL),
(4, NULL, 'Complete portfolio', '3 more tasks ', '2024-05-02', 'High', 'Not Started', 1, NULL),
(5, NULL, 'Reflective account', '', '2024-05-02', 'Medium', 'Not Started', 0, NULL),
(6, NULL, 'Test', 'hi', '2024-05-02', 'Medium', 'Not Started', 0, 62),
(7, NULL, 'Test 2', 'hello', '2024-05-02', 'Medium', 'Not Started', 0, 62),
(8, NULL, 'Complete portfolio', '', '2024-05-10', NULL, 'Not Started', 0, 62);

-- --------------------------------------------------------

--
-- Table structure for table `task_assignments`
--

CREATE TABLE `task_assignments` (
  `taskAssignmentId` int(11) NOT NULL,
  `groupTaskId` int(11) NOT NULL,
  `assignedUsersId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_assignments`
--

INSERT INTO `task_assignments` (`taskAssignmentId`, `groupTaskId`, `assignedUsersId`) VALUES
(1, 12, 61);

-- --------------------------------------------------------

--
-- Table structure for table `task_lists`
--

CREATE TABLE `task_lists` (
  `taskListId` int(11) NOT NULL,
  `usersId` int(11) NOT NULL,
  `taskListName` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `teamId` int(11) NOT NULL,
  `teamName` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`teamId`, `teamName`) VALUES
(19, 'Dev Team');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `teamMemberId` int(11) NOT NULL,
  `usersId` int(11) NOT NULL,
  `teamId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`teamMemberId`, `usersId`, `teamId`) VALUES
(1, 40, 19),
(3, 61, 19);

-- --------------------------------------------------------

--
-- Table structure for table `team_member_notification`
--

CREATE TABLE `team_member_notification` (
  `teamMemberNotificationId` int(11) NOT NULL,
  `teamMemberId` int(11) NOT NULL,
  `notificationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_member_task_assignment`
--

CREATE TABLE `team_member_task_assignment` (
  `assignmentId` int(11) NOT NULL,
  `teamMemberId` int(11) NOT NULL,
  `taskAssignmentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_projects`
--

CREATE TABLE `team_projects` (
  `projectId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `projectName` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersId` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersPassword` varchar(128) NOT NULL,
  `accountType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersPassword`, `accountType`) VALUES
(40, 'Maria', 'setsbynesss@gmail.com', '$2y$10$aJ46Y3r3G/zg6.C9sKBsbei9EapNaCH7vJMuzYWUTZiZqtxOUV2oC', 'team-user'),
(59, 'David', 'chirindanester@gmail.com', '$2y$10$UQvmgSFvJQtoF1C95/FR..E4pK26EenxjEu6LCyob.y.7dsvM83Bm', 'admin-user'),
(61, 'Harlee Watson', 'harlswats@gmail.com', '$2y$10$e3S7jKaL7tf29te5KjcA0eIVNzmer9tu1VZMpC.uBpg1bfDsree8e', 'team-user'),
(62, 'Sarah', 'so.minkedd@gmail.com', '$2y$10$dZ52P6xEILuWKZMph.rA0uux5B1ShKxBEPNfcg78c9A9skEcYomQS', 'basic-user');

-- --------------------------------------------------------

--
-- Table structure for table `user_shared_list`
--

CREATE TABLE `user_shared_list` (
  `userSharedListID` int(11) NOT NULL,
  `usersId` int(11) NOT NULL,
  `sharedListId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_theme_preferences`
--

CREATE TABLE `user_theme_preferences` (
  `usersId` int(11) NOT NULL,
  `themePreference` enum('Theme 1','Theme 2','Dark mode') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_admins`
--
ALTER TABLE `group_admins`
  ADD PRIMARY KEY (`groupId`),
  ADD KEY `usersId` (`usersId`),
  ADD KEY `teamId` (`teamId`);

--
-- Indexes for table `group_tasks`
--
ALTER TABLE `group_tasks`
  ADD PRIMARY KEY (`groupTaskId`),
  ADD KEY `teamId` (`teamId`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationId`),
  ADD KEY `usersId` (`usersId`);

--
-- Indexes for table `shared_lists`
--
ALTER TABLE `shared_lists`
  ADD PRIMARY KEY (`sharedListId`),
  ADD KEY `taskListId` (`taskListId`);

--
-- Indexes for table `sub_tasks`
--
ALTER TABLE `sub_tasks`
  ADD PRIMARY KEY (`subTaskId`),
  ADD KEY `taskId` (`taskId`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskId`),
  ADD KEY `taskListId` (`taskListId`),
  ADD KEY `fk_userId` (`usersId`);

--
-- Indexes for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD PRIMARY KEY (`taskAssignmentId`),
  ADD KEY `groupTaskId` (`groupTaskId`),
  ADD KEY `assignedUsersId` (`assignedUsersId`);

--
-- Indexes for table `task_lists`
--
ALTER TABLE `task_lists`
  ADD PRIMARY KEY (`taskListId`),
  ADD KEY `usersId` (`usersId`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`teamId`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`teamMemberId`),
  ADD KEY `usersId` (`usersId`),
  ADD KEY `teamId` (`teamId`);

--
-- Indexes for table `team_member_notification`
--
ALTER TABLE `team_member_notification`
  ADD PRIMARY KEY (`teamMemberNotificationId`),
  ADD KEY `teamMemberId` (`teamMemberId`),
  ADD KEY `notificationId` (`notificationId`);

--
-- Indexes for table `team_member_task_assignment`
--
ALTER TABLE `team_member_task_assignment`
  ADD PRIMARY KEY (`assignmentId`),
  ADD KEY `teamMemberId` (`teamMemberId`),
  ADD KEY `taskAssignmentId` (`taskAssignmentId`);

--
-- Indexes for table `team_projects`
--
ALTER TABLE `team_projects`
  ADD PRIMARY KEY (`projectId`),
  ADD KEY `teamId` (`teamId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- Indexes for table `user_shared_list`
--
ALTER TABLE `user_shared_list`
  ADD PRIMARY KEY (`userSharedListID`),
  ADD KEY `usersId` (`usersId`),
  ADD KEY `sharedListId` (`sharedListId`);

--
-- Indexes for table `user_theme_preferences`
--
ALTER TABLE `user_theme_preferences`
  ADD PRIMARY KEY (`usersId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_admins`
--
ALTER TABLE `group_admins`
  MODIFY `groupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `group_tasks`
--
ALTER TABLE `group_tasks`
  MODIFY `groupTaskId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notificationId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shared_lists`
--
ALTER TABLE `shared_lists`
  MODIFY `sharedListId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_tasks`
--
ALTER TABLE `sub_tasks`
  MODIFY `subTaskId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `task_assignments`
--
ALTER TABLE `task_assignments`
  MODIFY `taskAssignmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_lists`
--
ALTER TABLE `task_lists`
  MODIFY `taskListId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `teamId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `teamMemberId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team_member_notification`
--
ALTER TABLE `team_member_notification`
  MODIFY `teamMemberNotificationId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_member_task_assignment`
--
ALTER TABLE `team_member_task_assignment`
  MODIFY `assignmentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_projects`
--
ALTER TABLE `team_projects`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `user_shared_list`
--
ALTER TABLE `user_shared_list`
  MODIFY `userSharedListID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_admins`
--
ALTER TABLE `group_admins`
  ADD CONSTRAINT `group_admins_ibfk_1` FOREIGN KEY (`usersId`) REFERENCES `users` (`usersId`),
  ADD CONSTRAINT `group_admins_ibfk_2` FOREIGN KEY (`teamId`) REFERENCES `teams` (`teamId`);

--
-- Constraints for table `group_tasks`
--
ALTER TABLE `group_tasks`
  ADD CONSTRAINT `group_tasks_ibfk_1` FOREIGN KEY (`teamId`) REFERENCES `teams` (`teamId`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`usersId`) REFERENCES `users` (`usersId`);

--
-- Constraints for table `shared_lists`
--
ALTER TABLE `shared_lists`
  ADD CONSTRAINT `shared_lists_ibfk_1` FOREIGN KEY (`taskListId`) REFERENCES `task_lists` (`taskListId`);

--
-- Constraints for table `sub_tasks`
--
ALTER TABLE `sub_tasks`
  ADD CONSTRAINT `sub_tasks_ibfk_1` FOREIGN KEY (`taskId`) REFERENCES `tasks` (`taskId`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_userId` FOREIGN KEY (`usersId`) REFERENCES `users` (`usersId`),
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`taskListId`) REFERENCES `task_lists` (`taskListId`);

--
-- Constraints for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD CONSTRAINT `task_assignments_ibfk_1` FOREIGN KEY (`groupTaskId`) REFERENCES `group_tasks` (`groupTaskId`),
  ADD CONSTRAINT `task_assignments_ibfk_2` FOREIGN KEY (`assignedUsersId`) REFERENCES `users` (`usersId`);

--
-- Constraints for table `task_lists`
--
ALTER TABLE `task_lists`
  ADD CONSTRAINT `task_lists_ibfk_1` FOREIGN KEY (`usersId`) REFERENCES `users` (`usersId`);

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`usersId`) REFERENCES `users` (`usersId`),
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`teamId`) REFERENCES `teams` (`teamId`);

--
-- Constraints for table `team_member_notification`
--
ALTER TABLE `team_member_notification`
  ADD CONSTRAINT `team_member_notification_ibfk_1` FOREIGN KEY (`teamMemberId`) REFERENCES `team_members` (`teamMemberId`),
  ADD CONSTRAINT `team_member_notification_ibfk_2` FOREIGN KEY (`notificationId`) REFERENCES `notifications` (`notificationId`);

--
-- Constraints for table `team_member_task_assignment`
--
ALTER TABLE `team_member_task_assignment`
  ADD CONSTRAINT `team_member_task_assignment_ibfk_1` FOREIGN KEY (`teamMemberId`) REFERENCES `team_members` (`teamMemberId`),
  ADD CONSTRAINT `team_member_task_assignment_ibfk_2` FOREIGN KEY (`taskAssignmentId`) REFERENCES `task_assignments` (`taskAssignmentId`);

--
-- Constraints for table `team_projects`
--
ALTER TABLE `team_projects`
  ADD CONSTRAINT `team_projects_ibfk_1` FOREIGN KEY (`teamId`) REFERENCES `teams` (`teamId`);

--
-- Constraints for table `user_shared_list`
--
ALTER TABLE `user_shared_list`
  ADD CONSTRAINT `user_shared_list_ibfk_1` FOREIGN KEY (`usersId`) REFERENCES `users` (`usersId`),
  ADD CONSTRAINT `user_shared_list_ibfk_2` FOREIGN KEY (`sharedListId`) REFERENCES `shared_lists` (`sharedListId`);

--
-- Constraints for table `user_theme_preferences`
--
ALTER TABLE `user_theme_preferences`
  ADD CONSTRAINT `user_theme_preferences_ibfk_1` FOREIGN KEY (`usersId`) REFERENCES `users` (`usersId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
