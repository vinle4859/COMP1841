-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2025 at 12:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comp1841_coursework`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answer_id`, `content`, `is_accepted`, `image`, `status`, `created_at`, `user_id`, `question_id`) VALUES
(1, 'To center with flexbox, set `display: flex;`, `justify-content: center;`, and `align-items: center;` on the parent container. This centers it both horizontally and vertically.', 1, NULL, 'active', '2025-08-04 20:00:00', 5, 1),
(2, 'Just `display: flex;` and `justify-content: center;` on the parent is enough if you only want horizontal centering.', 0, NULL, 'active', '2025-08-04 21:15:00', 3, 1),
(3, 'Another modern way is using Grid. On the parent: `display: grid;` and `place-items: center;`', 0, NULL, 'active', '2025-08-04 22:00:00', 9, 1),
(4, 'A **Primary Key (PK)** uniquely identifies a row in *its own* table (e.g., `user_id` in the `users` table). A **Foreign Key (FK)** is a column in one table that links to the Primary Key of *another* table (e.g., `user_id` in your `answer` table links to the `user_id` in a `users` table). It enforces relationships.', 1, NULL, 'active', '2025-08-09 22:30:00', 6, 2),
(5, 'Think of it like this: A PK is your personal ID card number (unique to you). An FK is when your ID card number is written on an exam paper (linking the paper *to* you).', 0, NULL, 'active', '2025-08-09 23:00:00', 1, 2),
(6, 'It is used to maintain referential integrity. It stops you from adding an answer for a `user_id` that doesn\'t exist.', 0, NULL, 'active', '2025-08-11 02:00:00', 8, 2),
(7, 'This error on a Mac with XAMPP usually means the PHP script can\'t find the `mysql.sock` file. You need to tell PDO where it is. Find your `mysql.sock` path (try `/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock`) and add it to your DSN string.', 0, NULL, 'active', '2025-08-20 01:00:00', 7, 3),
(8, 'Check your `php.ini` file. Make sure the `pdo_mysql.default_socket` setting is pointing to the correct socket file for your XAMPP installation.', 0, NULL, 'active', '2025-08-20 01:15:00', 1, 3),
(9, 'A quick fix is to change `localhost` in your connection string to `127.0.0.1`. This forces PHP to use TCP/IP instead of a socket, which often bypasses this specific error.', 0, NULL, 'active', '2025-08-21 03:00:00', 5, 3),
(10, 'Agile is an iterative approach to project management. Instead of a big plan upfront (like Waterfall), you work in small cycles called **Sprints**. After each sprint, you deliver a small, working part of the project, get feedback, and adapt the plan for the next sprint.', 0, NULL, 'active', '2025-09-01 03:00:00', 1, 4),
(11, 'Waterfall is linear: Requirements -> Design -> Build -> Test -> Deploy. You can\'t go back easily. Agile is cyclical: (Plan -> Build -> Test -> Review) -> (Plan -> Build -> Test -> Review) ... It\'s all about flexibility and responding to change.', 0, NULL, 'active', '2025-09-01 04:30:00', 6, 4),
(12, 'Waterfall is better for projects where you know exactly what you need at the start.', 0, NULL, 'removed', '2025-09-02 02:00:00', 8, 4),
(13, 'This is a classic case of overfitting! Your model has memorized the training data instead of learning the general patterns. The most common fix is **regularization** (like L1 or L2) which penalizes complex models.', 0, NULL, 'active', '2025-09-04 21:00:00', 10, 5),
(14, 'You can also try **data augmentation** (creating more training data by slightly modifying your existing data), or use **dropout layers** if you are using a neural network.', 0, NULL, 'active', '2025-09-04 22:00:00', 3, 5),
(15, 'Another simple fix is to get more data. More data makes it harder for the model to memorize everything. Also, try simplifying your model (e.g., fewer layers or neurons).', 0, NULL, 'active', '2025-09-04 23:15:00', 7, 5),
(16, 'Noted, thank you.', 0, NULL, 'active', '2025-09-09 20:00:00', 2, 6),
(17, 'Understood.', 0, NULL, 'active', '2025-09-09 21:00:00', 5, 6),
(18, 'What if it\'s for a group project?', 0, NULL, 'active', '2025-09-09 22:00:00', 9, 6),
(19, 'You have to call `session_start();` at the *very* top of *every* script (like `dashboard.php`) where you want to access or modify the `$_SESSION` array. Before any HTML or `echo` statements.', 1, NULL, 'active', '2025-09-11 23:10:00', 4, 7),
(20, 'Yep, as you said in your post, you forgot `session_start()`. That function tells PHP to either resume the existing session or start a new one, allowing it to populate the `$_SESSION` superglobal.', 0, NULL, 'active', '2025-09-11 23:15:00', 2, 7),
(21, 'An **ERD (Entity-Relationship Diagram)** models the *database structure*. It shows tables, columns, and relationships (one-to-one, one-to-many). A **Class Diagram** models the *software (code) structure*. It shows classes, their attributes (variables), their methods (functions), and how classes relate to each other (inheritance, association).', 0, NULL, 'active', '2025-09-30 22:00:00', 3, 8),
(22, 'They look similar but serve different purposes. ERD is for data-centric design (the database). Class Diagram is for object-oriented design (the application logic).', 0, NULL, 'active', '2025-09-30 23:30:00', 6, 8),
(23, 'A simple way to think about it: An ERD becomes your SQL `CREATE TABLE` statements. A Class Diagram becomes your `class User { ... }` definitions in PHP, Python, or Java.', 0, NULL, 'active', '2025-10-02 02:00:00', 1, 8),
(24, '`NULL` is not the same as `0` or an empty string (`\'\'`). `NULL` means \"a missing or unknown value\". `0` is a number and `\'\'` is a string with zero length. They are all different.', 0, NULL, 'active', '2025-10-15 01:30:00', 5, 9),
(25, 'Because `NULL` means \"unknown\", you can\'t use standard operators like `=` or `!=` with it. To check for `NULL`, you *must* use `WHERE my_column IS NULL` or `WHERE my_column IS NOT NULL`.', 0, NULL, 'active', '2025-10-15 01:45:00', 7, 9),
(26, 'This is why your `WHERE my_column = NULL` query is failing. It will never return true. You must use `IS NULL`.', 0, NULL, 'active', '2025-10-15 02:00:00', 3, 9),
(27, 'Response to question 6, reply to answer 18: Especially not for a group project. Use a shared drive or a version control system like Git. Never share your personal credentials.', 0, NULL, 'active', '2025-09-09 23:00:00', 1, 6),
(28, 'Just use `WHERE my_column = 0`, it\'s the same thing.', 0, NULL, 'removed', '2025-10-15 03:00:00', 4, 9),
(29, 'Python is generally preferred if you want to be a well-rounded data scientist who also needs to build applications, integrate with web servers, or do general-purpose programming. It has great libraries like Pandas, Scikit-learn, and TensorFlow.', 0, NULL, 'active', '2025-10-31 03:00:00', 10, 13),
(30, 'R is fantastic for pure statistical analysis and visualization. It was built by statisticians *for* statisticians. Its libraries (like `ggplot2` and the `tidyverse`) are incredibly powerful for data exploration and academic research.', 0, NULL, 'active', '2025-10-31 03:05:00', 6, 13),
(31, 'Honestly, you can\'t go wrong. Python is more versatile (general-purpose), R is more specialized (statistics). Many data scientists know both. I\'d start with Python as it\'s easier to branch out from there.', 0, NULL, 'active', '2025-10-31 04:00:00', 3, 13),
(32, 'Python has a gentler learning curve for people new to programming. R\'s syntax can be a bit quirky at first, but it\'s very powerful once you get it.', 0, NULL, 'active', '2025-11-01 02:00:00', 9, 13);

-- --------------------------------------------------------

--
-- Table structure for table `answer_like`
--

CREATE TABLE `answer_like` (
  `user_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sender_name` varchar(100) DEFAULT NULL,
  `sender_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`) VALUES
(1, 'Web Programming'),
(2, 'Software Engineering'),
(3, 'Machine Learning'),
(4, 'Data Science');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `title`, `content`, `image`, `view_count`, `status`, `created_at`, `user_id`, `module_id`, `updated_at`) VALUES
(1, 'How do I center a div?', 'I have tried margin: auto but it\'s not working. What is the modern way using flexbox?', 'img1.jpg', 150, 'active', '2025-08-04 02:15:00', 2, 1, '2025-11-07 07:24:07'),
(2, 'What is a foreign key?', 'I don\'t understand the difference between a primary key and a foreign key. Can someone explain?', 'img2.jpg', 302, 'closed', '2025-08-09 04:00:00', 3, 4, '2025-11-01 05:24:08'),
(3, 'PHP PDO connection error', 'I\'m getting \"SQLSTATE[HY000] [2002] No such file or directory\". I am using XAMPP on a Mac. My code is attached.                ', 'img3.jpg', 75, 'active', '2025-08-19 07:30:00', 4, 1, '2025-11-07 11:06:36'),
(4, 'What is Agile?', 'The lecturer mentioned \"Agile\" and \"Sprints\". How is this different from the Waterfall model?', 'img4.jpg', 45, 'active', '2025-08-31 09:00:00', 2, 2, '2025-11-01 05:24:17'),
(5, 'Machine Learning Overfitting', 'My ML model is doing exceptionally well during training but it drops hard during test. How can I fix this?', 'img5.jpg', 112, 'active', '2025-09-04 03:20:00', 7, 3, '2025-11-01 05:24:20'),
(6, 'Reminder: Do not share passwords', 'This is a reminder that sharing passwords is a violation of university policy.', 'img6.jpg', 500, 'active', '2025-09-09 02:00:00', 6, 2, '2025-11-01 05:24:23'),
(7, 'How to use $_SESSION variable?', 'I set a session variable on login.php but when I go to dashboard.php it is empty. I forgot to use session_start().', 'img7.jpg', 850, 'closed', '2025-09-11 06:00:00', 8, 1, '2025-11-01 05:24:26'),
(8, 'What is a Class Diagram?', 'How is an ERD different from a Class Diagram? They look similar.', 'img8.jpg', 25, 'active', '2025-09-30 04:30:00', 9, 2, '2025-11-01 05:24:30'),
(9, 'What does NULL mean?', 'Is NULL the same as 0 or an empty string? My WHERE clause is not working.', 'img9.jpg', 12, 'active', '2025-10-14 08:00:00', 10, 4, '2025-11-01 05:24:34'),
(10, 'How to hack wifi?', 'Just asking for a friend for a class project.', 'img10.jpg', 2, 'removed_by_admin', '2025-10-20 03:00:00', 4, 1, '2025-10-31 07:08:50'),
(13, 'Which language?', 'Should I study R or Python for DS?', 'img11.jpg', 10, 'active', '2025-10-30 09:01:53', 8, 4, '2025-11-01 05:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `question_like`
--

CREATE TABLE `question_like` (
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_tag`
--

CREATE TABLE `question_tag` (
  `question_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(2, 'Administrator'),
(1, 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`user_id`, `username`, `email`, `password`, `status`, `created_at`) VALUES
(1, 'admin_user', 'admin@example.com', '$2y$10$abc...', 'active', '2025-08-01 03:00:00'),
(2, 'alexj', 'alexj@example.com', '$2y$10$def...', 'active', '2025-08-10 04:30:00'),
(3, 'blue_ocean', 'blue@example.com', '$2y$10$ghi...', 'active', '2025-08-11 07:15:00'),
(4, 'coding_finch', 'finch@example.com', '$2y$10$jkl...', 'active', '2025-08-12 02:05:00'),
(5, 'dev_dave', 'dave@example.com', '$2y$10$mno...', 'active', '2025-08-13 09:20:00'),
(6, 'ella_b', 'ella@example.com', '$2y$10$pqr...', 'active', '2025-08-14 04:10:00'),
(7, 'green_leaf', 'green@example.com', '$2y$10$stu...', 'active', '2025-08-15 03:00:00'),
(8, 'sky_rider', 'sky@example.com', '$2y$10$vwx...', 'active', '2025-08-16 06:45:00'),
(9, 'sunny_daze', 'sunny@example.com', '$2y$10$yza...', 'active', '2025-08-17 08:00:00'),
(10, 'pixel_pro', 'pixel@example.com', '$2y$10$bcd...', 'active', '2025-08-18 10:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_module`
--

CREATE TABLE `user_module` (
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(1, 2),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `answer_like`
--
ALTER TABLE `answer_like`
  ADD PRIMARY KEY (`user_id`,`answer_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `question_like`
--
ALTER TABLE `question_like`
  ADD PRIMARY KEY (`user_id`,`question_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `question_tag`
--
ALTER TABLE `question_tag`
  ADD PRIMARY KEY (`question_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_module`
--
ALTER TABLE `user_module`
  ADD PRIMARY KEY (`user_id`,`module_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `answer_like`
--
ALTER TABLE `answer_like`
  ADD CONSTRAINT `answer_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answer_like_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`answer_id`) ON DELETE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user_account` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`);

--
-- Constraints for table `question_like`
--
ALTER TABLE `question_like`
  ADD CONSTRAINT `question_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_like_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `question_tag`
--
ALTER TABLE `question_tag`
  ADD CONSTRAINT `question_tag_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_module`
--
ALTER TABLE `user_module`
  ADD CONSTRAINT `user_module_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_module_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
