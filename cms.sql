-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 10:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) UNSIGNED NOT NULL,
  `cat_title` varchar(255) NOT NULL,
  `user_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`, `user_id`) VALUES
(1, 'Start Bootstrap', 41),
(3, 'Java', 41),
(4, 'PHP', 0),
(21, 'Adv. Java', 41),
(22, 'Python', 0),
(23, 'JavaScript', 0),
(32, 'C++', 0),
(85, 'Demo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(32) NOT NULL,
  `comment_email` varchar(100) NOT NULL,
  `comment_content` text NOT NULL,
  `In_response_to` varchar(255) NOT NULL,
  `comment_status` varchar(32) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `In_response_to`, `comment_status`, `comment_date`) VALUES
(107, 9, 'Sam', 'dsaa@dfg.com', 'dasfgnmnm', 'Python Tutorials', 'approve', '2023-08-01'),
(108, 9, 'Sam', 'dsaa@dfg.com', 'dasfgnmnm', 'Python Tutorials', 'approve', '2023-08-01'),
(109, 18, 'Sam', 'dsaa@dfg.com', 'fssd', 'New Procedural PHP', 'approve', '2023-08-01'),
(110, 18, 'Sam', 'dsaa@dfg.com', 'fssd', 'New Procedural PHP', 'approve', '2023-08-01'),
(111, 7, 'Sam', 'dsaa@dfg.com', 'aaaa', 'New Procedural PHP', 'approve', '2023-08-01'),
(112, 7, 'Sam', 'dsaa@dfg.com', 'sfghjhg', '', 'approve', '2023-08-01'),
(113, 7, 'Sam', 'dsaa@dfg.com', 'sfghjhg', 'New Procedural PHP', 'approve', '2023-08-01'),
(114, 35, 'Ron', 'ron123@gmail.com', 'dfghfgh', 'Django', 'approve', '2023-08-04'),
(115, 34, 'Sam', 'sam247@sam.com', 'fghfgh', 'Java', 'approve', '2023-08-04'),
(116, 51, 'Sam', 'sdfg@dfgh.com', 'rfghj', 'Demo', 'approved', '2023-08-29'),
(117, 47, 'Rohon', 'ron123@gmail.com', 'dfghj', 'Java Tutorial', 'approve', '2023-09-04');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `post_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(14, 41, 8),
(17, 41, 7),
(18, 48, 7),
(19, 41, 20);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_creator` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_view_count` int(11) NOT NULL,
  `likes` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `post_category_id`, `post_title`, `post_creator`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_view_count`, `likes`) VALUES
(7, 0, 4, 'New Procedural PHP', 'S_Smith', '2023-09-05', 'procedural_PHP_tutorial.jpg', 'This is the procedural PHP tutorials.', 'PHP, Procedural, Tutorials', 14, 'Draft', 100, 12),
(8, 0, 23, 'JavaScript Blog', 'S_Smith', '2023-08-21', 'javascript_Pic.png', 'New JavaScript Tutorials.', 'javascript, tutorials, info', 4, 'published', 157, 14),
(9, 0, 22, 'Python Tutorials', 'pyMaster', '2023-08-21', 'python.png', 'This Python tutorial has been written for the beginners to help them understand the basic to advanced concepts of Python Programming Language.', 'Python, tutorials, info', 5, 'published', 50, 0),
(16, 0, 22, 'Django', 'pyMaster', '2023-08-21', 'python-django.png', '<span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif;\"><b><u>Django</u></b> is a free and open-source, Python-based web framework that follows the model–template–views architectural pattern. It is maintained by the Django Software Foundation, an independent organization established in the US as a 501 non-profit.</span>', 'Django, Python, Tutorials', 4, 'published', 22, 0),
(20, 0, 4, 'New Procedural PHP', 'S_Smith', '2023-08-21', 'procedural_php.jpg', 'This is the procedural PHP tutorials.', 'PHP, Procedural, Tutorials', 0, 'draft', 16, 1),
(22, 0, 4, 'New Procedural PHP', 'S_Smith', '2023-08-18', 'procedural_php.jpg', 'This is the procedural PHP tutorials.', 'PHP, Procedural, Tutorials', 0, 'draft', 4, 0),
(23, 0, 23, 'JavaScript Blog', 'S_Smith', '2023-07-27', 'javascript_Pic.png', 'New JavaScript Tutorials.', 'javascript, tutorials, info', 0, 'published', 2, 0),
(24, 0, 4, 'New Procedural PHP', 'S_Smith', '2023-07-27', 'procedural_php.jpg', 'This is the procedural PHP tutorials.', 'PHP, Procedural, Tutorials', 0, 'draft', 0, 0),
(27, 0, 23, 'JavaScript Blog', 'S_Smith', '2023-08-18', 'javascript_Pic.png', 'New JavaScript Tutorials.', 'javascript, tutorials, info', 0, 'published', 6, 0),
(30, 0, 4, 'New Procedural PHP', 'S_Smith', '2023-08-21', 'procedural_php.jpg', 'This is the procedural PHP tutorials.', 'PHP, Procedural, Tutorials', 3, 'draft', 6, 0),
(38, 0, 4, 'New Procedural PHP', 'S_Smith', '2023-08-18', 'procedural_php.jpg', 'This is the procedural PHP tutorials.                        ', 'PHP, Procedural, Tutorials', 0, 'draft', 0, 0),
(39, 0, 23, 'JavaScript Blog', 'S_Smith', '2023-09-05', 'javaScript.png', '<p>New JavaScript Tutorials.</p><p><br></p><p><br></p><p><br></p><p><br></p><p>        </p>', 'javascript, tutorials, info', 0, 'Draft', 1, 0),
(40, 0, 22, 'Django', 'pyMaster', '2023-08-18', 'python-django.png', '<span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif;\"><b><u>Django</u></b> is a free and open-source, Python-based web framework that follows the model–template–views architectural pattern. It is maintained by the Django Software Foundation, an independent organization established in the US as a 501 non-profit.</span>', 'Django, Python, Tutorials', 0, 'published', 1, 0),
(41, 0, 22, 'Python Tutorials', 'pyMaster', '2023-08-21', 'python.png', '<p>This Python tutorial has been written for the beginners to help them understand the basic to advanced concepts of Python Programming Language.</p><p><br></p><p><br></p><p><br></p><p>        </p>', 'Python, tutorials, info', 0, 'published', 0, 0),
(43, 41, 3, 'Adv. Java', 'Rohon', '2023-08-21', 'Java-Logo.png', '<span style=\"color: rgb(77, 81, 86); font-family: &quot;Google Sans&quot;, arial, sans-serif; font-size: 16px;\">Everything that is beyond Core Java is known as Advanced Java. This includes the application programming interfaces (APIs) that are specified in Java Enterprise Edition, as well as Servlet programming, Web Services, the API, and so on.</span>', '', 0, 'published', 3, 0),
(44, 0, 4, 'New Procedural PHP', 'S_Smith', '2023-09-05', 'procedural_PHP_tutorial.jpg', 'This is the procedural PHP tutorials.', 'PHP, Procedural, Tutorials', 0, 'Draft', 2, 0),
(45, 0, 22, 'Django', 'pyMaster', '2023-08-22', 'python-django.png', '<span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif;\"><b><u>Django</u></b> is a free and open-source, Python-based web framework that follows the model–template–views architectural pattern. It is maintained by the Django Software Foundation, an independent organization established in the US as a 501 non-profit.</span>', 'Django, Python, Tutorials', 0, 'published', 3, 0),
(46, 41, 3, 'Java Tutorial', 'Rohon', '2023-08-22', 'Java-Logo.png', '<span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif;\">The Java Tutorials are practical guides for programmers who want to use the&nbsp;</span><span style=\"font-weight: bold; color: rgb(95, 99, 104); font-family: arial, sans-serif;\">Java programming</span><span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif;\">&nbsp;language to create applications.</span>', 'java, tutorials, info', 0, 'published', 1, 0),
(47, 41, 3, 'Java Tutorial', 'Rohon', '2023-08-22', 'Java-Logo.png', '<span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif;\">The Java Tutorials are practical guides for programmers who want to use the&nbsp;</span><span style=\"font-weight: bold; color: rgb(95, 99, 104); font-family: arial, sans-serif;\">Java programming</span><span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif;\">&nbsp;language to create applications.</span>', 'java, tutorials, info', 0, 'published', 3, 0),
(48, 0, 22, 'Python Tutorials', 'pyMaster', '2023-09-05', 'python.png', '<p>This Python tutorial has been written for the beginners to help them understand the basic to advanced concepts of Python Programming Language.</p><p><br></p><p><br></p><p><br></p><p>        </p>', 'Python, tutorials, info', 0, 'Draft', 1, 0),
(49, 0, 23, 'JavaScript Blog', 'S_Smith', '2023-09-05', 'javaScript.png', '<p>New JavaScript Tutorials.</p><p><br></p><p><br></p><p><br></p><p><br></p><p>        </p>', 'javascript, tutorials, info', 0, 'Draft', 1, 0),
(50, 41, 1, 'MY Bootstrap Tutorial', 'Rohon', '2023-09-05', 'bootstrap_logo-fotor.png', '<span style=\"color: rgb(77, 81, 86); font-family: \"Google Sans\", arial, sans-serif; font-size: 16px;\">What is Bootstrap? Bootstrap is </span><span style=\"background-color: rgba(80, 151, 255, 0.18); color: rgb(4, 12, 40); font-family: \"Google Sans\", arial, sans-serif; font-size: 16px;\">a free, open source front-end development framework for the creation of websites and web apps</span><span style=\"color: rgb(77, 81, 86); font-family: \"Google Sans\", arial, sans-serif; font-size: 16px;\">. Designed to enable responsive development of mobile-first websites, Bootstrap provides a collection of syntax for template designs.</span>', 'Bootstrap, Tutorials', 0, 'Draft', 8, 0),
(51, 41, 32, 'Demo', 'Rohon', '2023-09-05', 'What_is_CPP.avif', 'This post is for testing...', 'Demo, Testing', 0, 'Draft', 20, 0),
(52, 0, 1, 'BootsTrap_Tutorials', '', '2023-09-05', 'bootstrap_logo-fotor.png', '<span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif;\">Bootstrap is a free and open-source CSS framework directed at responsive, mobile-first front-end web development. It contains HTML, CSS and JavaScript-based design templates for typography, forms, buttons, navigation, and other interface components.</span>', 'Bootstrap, Tutorials', 0, 'Draft', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(100) NOT NULL,
  `reg_date` date NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `firstname`, `lastname`, `user_email`, `user_image`, `user_role`, `reg_date`, `token`) VALUES
(1, 'test01', '1234', 'test_01', 'test1', 'test@gmail.com', '', 'admin', '0000-00-00', ''),
(37, 'sam247', '$2y$08$jlQkcDaONjGH8YdhzhjbLeKGyEDUOr8QG9fH06zSgsnkxqyWlSdsS', 'Sam', '247', 'sam247@gmail.com', '', 'Admin', '0000-00-00', ''),
(39, 'kavin247', '$2y$08$iNZV0ZuFl1PUIPr/JdcsKOjHlk1p4PUBuIAZxUXX9tHlULS27HnQq', 'Kavin', '247', 'kavin247@gmail.com', '', 'Subscriber', '2023-08-04', ''),
(41, 'rohon247', '$2y$08$pLpEQLSnjHqks8J9KklwZex6z0y7cp50EMUAnIf8l0aGGrC2DYo1y', 'Rohon', '247', 'rohon247@gmail.com', '', 'Subscriber', '2023-08-05', ''),
(42, 'fghgfd', '$2y$08$EVmThJScPK.0wKYlcsdKPeQu54t5b4BSp6o6cx8mAoBb13gMKxyL6', 'dfgfhgg', 'dfgh', 'Sam247@gmail.com', '', 'Subscriber', '2023-08-05', ''),
(47, 'rupa247', '$2y$08$hGwgEjoDKsSriTCWWEGF8uoE4P.LV/u/u7gpbIKIGePEY/hS8Akae', '', '', 'rupa247@gmail.com', '', 'Subscriber', '2023-08-22', ''),
(48, 'bob247', '$2y$08$v1LzlYPaLFOuUY4AtRvkMuIpaexXH7/4OjZ.JRDOTNCjPP9Rd736e', '', '', 'bob247@gmail.com', '', 'Admin', '2023-08-22', ''),
(49, 'nicole247', '$2y$08$jvwK0nsp..TMng66VW7SpOMRDbv751OGtqt/CvWGTLZzJbOa/tnWe', 'Nicole', '247', 'nicole247@gmail.com', '', '', '2023-08-22', ''),
(50, 'newmoon247', '$2y$08$lE3NfE4f/Xiv9qv5vQIFFu70LpQN3tBVvAN5B6JKW7LXhG5yhtGhO', '', '', 'newmoon247@newmoon.com', '', 'Subscriber', '2023-08-22', ''),
(51, 'ron247', '$2y$08$r1Rs6BJZZtb1VhDR8AV31eC4ePUwYP4cvIFabQfQ5fltxkz1UHbcm', 'Ron', '247', 'ron247@gmail.com', '', 'Subscriber', '2023-08-25', ''),
(52, 'samirul', '$2y$12$FlYC2SW7fJjHwPUfRPWz6erbxIjKSlVyRH6QIbmjF4GG1ADL1ovhm', '', '', 'samirul1992@gmail.com', '', 'Subscriber', '2023-08-26', ''),
(53, 'Abhijit247', '$2y$08$8bS5deWkS6vJJfwhDkQKXuIGGeU0B6G9/bQP1AeZU/HH/8Ptm5.A2', '', '', 'samirul077islam@gmail.com', '', 'Subscriber', '2023-12-08', ''),
(59, 'test02', '$2y$08$zgznmD4DlqpBsT2tpEjEzeBeHm1v77TIlpoGI9XbPtJb7HLg51NEy', '', '', 'test02@gmail.com', '', 'Subscriber', '2024-03-13', ''),
(61, 'test03', '$2y$08$USwr/yRX6Ks/iel6ao6kAOR7EZkmGzI96YYkwq6rb1jRLN2hkP.hC', '', '', 'test03@gmail.com', '', 'Subscriber', '2024-03-13', ''),
(63, 'test04', '$2y$08$JcyezfsNHbXsoK0YrIVuj.hBhEvJDSBa2UK.t5EOB2as.Q7U0UYPK', '', '', 'test04@gmail', '', 'Subscriber', '2024-03-13', ''),
(64, 'username', 'user_password', '', '', 'user_email', '', '', '0000-00-00', ''),
(65, 'test07', '$2y$08$t6d/RzoUwZM7uFxtoLozCe4BzG60OyUYpuhSXyVNckRq7MSM/XtR6', 'test', '07', 'test07@gmail.com', '', 'admin', '2024-05-03', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `log_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session_id`, `log_time`) VALUES
(1, '2fsj181ckrel2tse5fe8pi0l7l', 1691051753),
(2, '1q8a5f52j8aqm11edcqurl0mhv', 1691047589),
(3, '3b6s4hk9tefe591rcbd5d490tg', 1691047552),
(4, '78uple4s3mgo6crcisflk33bku', 1691051424),
(5, 'smqno86nf24fnjv12111m79dvm', 1691160751),
(6, '2ud9kk3ef076c4tnmr20dijq5r', 1691119402),
(7, 'pc1e6uq8l3akpd9bnpk75sgekg', 1691245138),
(8, 'p85hjrr5m509e7atgb3qak5kt1', 1691844541),
(9, '2s4aiamqd6ifdchinhsccesba8', 1691862532),
(10, 'kmtb8tnecrrrl1ksvnlvrhcl6o', 1692369889),
(11, 'vfvbj43qdpnmqupgee8opn1p9u', 1692611874),
(12, 'k6c9j90gqse0s23901koo6plim', 1692687033),
(13, 'njfgm35vou70tkor25kppulcsp', 1692730993),
(14, 'e8l08vn47isttjdddfo7hh2q9a', 1692768678),
(15, 'ktu8fts5houlnd9b0vrgrrlbbj', 1692791644),
(16, '9d6suv84bm23c4gc715ujj7o8j', 1692954973),
(17, '2n42eq3r3066o7r4nuuhgdumn0', 1693060573),
(18, '6c5srhhafaqujc55q646sanote', 1693074293),
(19, 'hdhp7hp1fiqc7cjvck54opkh9r', 1693201150),
(20, 'ibamip96v0m4cnmm1mdo9rald7', 1693272985),
(21, '6rgqp5vmstv4f3bt2idri548kf', 1693309597),
(22, 'u5oq89a2s7ld5a9nshvum3tec5', 1693372063),
(23, 'c1duvlfsa70qavmsc3l3i3d37i', 1693546928),
(24, '7tckt6odnl0ov8fu2b55lm85ml', 1693592996),
(25, '3osjjnn0auhk97l81l2tqlq21l', 1693660521),
(26, 'gt1kjbk7d8vfmr5c0ubrlnjrsu', 1693660953),
(27, 'c6acffjd238iiea1h20dhjnt12', 1693750700),
(28, 'l0k7qj1r4h3aor8kmuqn08lqc6', 1693817436),
(29, 'jg1d5mmkcs03233slv2cuiesfn', 1693830422),
(30, 'fksi10pu31p96q11pqpaqhgupv', 1693859463),
(31, 'p8li3061l2ju8jhk5bav6h0tgk', 1702052915),
(32, 'kjqipv2f3iuni1r3d1dgnk68tu', 1706611389),
(33, 's22a1fjql9bgsjskp977avrr7t', 1707285326),
(34, '9un664m6otrofsjkh1mfg6p7q0', 1709239638),
(35, 'd07q1noe0kqvqith367p7b2and', 1709391404),
(36, 'u6fq3dd090k5iktpt68mgoa61h', 1710004377),
(37, 'j9tt8v6ro15ujv26mam5o08n3s', 1710047089),
(38, 'gtd78r34ti6hst7pa07dfa4un7', 1714992084),
(39, 'c8b0kvd75gt27o21ktnaph7uhl', 1715004134),
(40, 'vdoi6c32bjrj46kokuv14locqo', 1715093278),
(41, '52bqv4si3cg0hl3f33p31ltr79', 1715165152),
(42, '1cjb0rh0l3shjfi6t8vi28smek', 1715183784),
(43, '5ap4q8r06lpddeiohqlkedsvjk', 1715242637),
(44, '5is0phmmi6r1jg7n5b7h69n3gp', 1715265059);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
