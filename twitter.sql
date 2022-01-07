-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2022 at 04:16 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentID` int(11) NOT NULL,
  `commentBy` int(11) NOT NULL,
  `commentOn` int(11) NOT NULL,
  `comment` text NOT NULL,
  `commentAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentID`, `commentBy`, `commentOn`, `comment`, `commentAt`) VALUES
(37, 42, 154, 'đasadsad', '2021-12-31 15:36:58'),
(38, 42, 155, 'Trẻ trâu vcl', '2021-12-31 21:43:57'),
(39, 42, 159, 'đasadsa', '2022-01-01 21:27:41'),
(40, 42, 157, 'alo', '2022-01-01 21:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `followID` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `followStatus` enum('0','1') NOT NULL,
  `followOn` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`followID`, `sender`, `receiver`, `followStatus`, `followOn`) VALUES
(70, 43, 42, '1', '2021-12-31 15:41:27'),
(72, 45, 42, '1', '2021-12-31 20:48:49'),
(74, 42, 43, '1', '2022-01-01 21:27:50');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likeID` int(11) NOT NULL,
  `likeOn` int(11) NOT NULL,
  `likeBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`likeID`, `likeOn`, `likeBy`) VALUES
(200, 154, 42),
(201, 155, 42),
(202, 155, 43),
(204, 158, 42),
(205, 159, 42),
(206, 157, 42);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageID` int(11) NOT NULL,
  `message` text NOT NULL,
  `messageTo` int(11) NOT NULL,
  `messageFrom` int(11) NOT NULL,
  `messageOn` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageID`, `message`, `messageTo`, `messageFrom`, `messageOn`, `status`) VALUES
(129, 'hello bé', 45, 42, '2021-12-30 23:46:59', 0),
(130, 'Dạ có chi ko anh', 42, 45, '2021-12-30 23:47:49', 0),
(145, 'đasadsa', 43, 42, '2022-01-01 16:46:46', 0),
(146, 'dsadsad', 42, 43, '2022-01-01 16:46:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notificationID` int(11) NOT NULL,
  `notificationFor` int(11) NOT NULL,
  `notificationFrom` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `type` enum('like','comment','retweet','follow','message','mention') NOT NULL,
  `notificationOn` datetime NOT NULL DEFAULT current_timestamp(),
  `notificationCount` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notificationID`, `notificationFor`, `notificationFrom`, `target`, `type`, `notificationOn`, `notificationCount`, `status`) VALUES
(188, 45, 42, 129, 'message', '2021-12-30 23:46:59', 1, 1),
(189, 42, 45, 130, 'message', '2021-12-30 23:47:49', 1, 1),
(193, 42, 43, 0, 'follow', '2021-12-31 15:41:27', 1, 0),
(194, 42, 43, 155, 'like', '2021-12-31 15:41:33', 1, 1),
(196, 42, 45, 0, 'follow', '2021-12-31 20:48:49', 1, 0),
(198, 42, 43, 157, 'mention', '2021-12-31 22:21:53', 1, 0),
(199, 45, 42, 131, 'message', '2022-01-01 12:58:00', 0, 0),
(200, 43, 42, 132, 'message', '2022-01-01 15:43:59', 1, 1),
(201, 42, 43, 133, 'message', '2022-01-01 15:44:31', 1, 0),
(202, 42, 43, 134, 'message', '2022-01-01 15:44:40', 1, 0),
(203, 43, 42, 135, 'message', '2022-01-01 15:44:44', 1, 0),
(204, 43, 42, 136, 'message', '2022-01-01 15:49:35', 1, 0),
(205, 43, 42, 137, 'message', '2022-01-01 15:54:04', 1, 1),
(206, 43, 42, 138, 'message', '2022-01-01 15:54:46', 1, 1),
(207, 43, 42, 139, 'message', '2022-01-01 16:03:33', 1, 0),
(208, 43, 42, 140, 'message', '2022-01-01 16:34:30', 1, 0),
(209, 45, 42, 141, 'message', '2022-01-01 16:36:42', 0, 0),
(210, 43, 42, 142, 'message', '2022-01-01 16:43:33', 1, 1),
(211, 42, 43, 143, 'message', '2022-01-01 16:44:03', 1, 0),
(212, 42, 43, 144, 'message', '2022-01-01 16:44:07', 1, 1),
(213, 43, 42, 145, 'message', '2022-01-01 16:46:46', 1, 0),
(214, 42, 43, 146, 'message', '2022-01-01 16:46:51', 1, 1),
(215, 43, 42, 0, 'follow', '2022-01-01 21:27:50', 1, 0),
(216, 43, 42, 157, 'like', '2022-01-01 21:27:53', 1, 1),
(217, 43, 42, 157, 'comment', '2022-01-01 21:27:57', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Bio` text NOT NULL,
  `birthday` date NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `profileImage` text NOT NULL,
  `profileCover` text NOT NULL,
  `gender` varchar(255) NOT NULL,
  `profession` text NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `Bio`, `birthday`, `country`, `website`, `firstName`, `lastName`, `profileImage`, `profileCover`, `gender`, `profession`, `email`) VALUES
(16, 42, 'Nothing is impossible hahaha', '2001-09-15', 'Quảng Nam', 'https://www.facebook.com/danhtrinh.dev/', 'Danh', 'Trinh', 'frontend/profileImage/42/7b35db7a4412dd37e68ee1f5b.png', 'frontend/profileCover/42/77ce1b14e7c44afa4b58ca644.png', 'Nam', 'Trai ngành', 'congdanhndh@gmail.com'),
(17, 43, '', '0000-00-00', '', '', 'Justin', 'Bieber', 'frontend/assets/images/profilePic.jpeg', 'frontend/assets/images/backgroundCoverPic.svg', '', '', 'sunshine15092001@gmail.com'),
(19, 45, '', '0000-00-00', '', '', 'Dang', 'Duong', 'frontend/profileImage/45/367312bad8f79cc5b45436128.png', 'frontend/profileCover/45/079970ac17b7efe6d198d400f.png', '', '', '19521326@gm.uit.edu.vn');

-- --------------------------------------------------------

--
-- Table structure for table `retweet`
--

CREATE TABLE `retweet` (
  `retweetID` int(11) NOT NULL,
  `retweetBy` int(11) NOT NULL,
  `retweetFrom` int(11) NOT NULL,
  `status` text NOT NULL,
  `tweetOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`id`, `user_id`, `token`) VALUES
(130, 43, '890f94304d90d75a60f9180dda73cf62e1e2cf55'),
(132, 43, '2fd8126d2c41734b4da2d582fad79a6695ece593'),
(133, 42, 'd552e5f893ac4c456d0477b23e3c8eda452d3ef6'),
(134, 43, '583b7f36d17fe3882717cdcb4581e8f033b88232'),
(135, 43, '8baea01124ce44cb08123a552bd40bd93424bcd6'),
(136, 43, 'ac00b9c467978d774e65f113ea04021ed82cf4ca'),
(137, 43, '0921f0b32fa66b5f1c6eb5285aeac56e1ae8783a');

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE `trends` (
  `trendID` int(11) NOT NULL,
  `tweetID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hashtag` varchar(200) NOT NULL,
  `createdOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `tweetID` int(11) NOT NULL,
  `status` text NOT NULL,
  `tweetBy` int(11) NOT NULL,
  `tweetImage` text NOT NULL,
  `postedOn` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`tweetID`, `status`, `tweetBy`, `tweetImage`, `postedOn`) VALUES
(156, '10 15 20, Baby i find your love', 45, 'frontend/media/7609824dffaa368a948c6081c.jpg', '2021-12-31 20:48:42'),
(157, '@danhtrinh alo', 43, '', '2021-12-31 22:21:53'),
(158, '10 15 20, baby i find your love ', 42, '', '2022-01-01 11:10:30'),
(159, 'dsadasdsa\n', 42, '', '2022-01-01 21:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `profileCover` varchar(255) NOT NULL,
  `following` int(11) NOT NULL,
  `followers` int(11) NOT NULL,
  `bio` text NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `signUpDate` datetime NOT NULL,
  `profileEdit` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstName`, `lastName`, `username`, `email`, `password`, `profileImage`, `profileCover`, `following`, `followers`, `bio`, `country`, `website`, `signUpDate`, `profileEdit`) VALUES
(42, 'Danh', 'Trinh', 'danhtrinh', 'congdanhndh@gmail.com', '$2y$10$cekzU2VmaA7UTE40z9y1DO76649n1Gi8Qu51W0uyCgfhfZbUJ/e1W', 'frontend/profileImage/42/7b35db7a4412dd37e68ee1f5b.png', 'frontend/profileCover/42/77ce1b14e7c44afa4b58ca644.png', 1, 2, 'Nothing is impossible hahaha', 'Quảng Nam', 'https://www.facebook.com/danhtrinh.dev/', '2021-12-30 22:20:42', '1'),
(43, 'Justin', 'Bieber', 'justinbieber', 'sunshine15092001@gmail.com', '$2y$10$Ie2e/aCBniFTK1NBC.mVXuIRomS98626PS7c6y2Le7VGdbdtGDEW6', 'frontend/assets/images/profilePic.jpeg', 'frontend/assets/images/backgroundCoverPic.svg', 1, 1, '', '', '', '2021-12-30 22:23:19', '0'),
(45, 'Dang', 'Duong', 'dangduong', '19521326@gm.uit.edu.vn', '$2y$10$MW8J./P9jB12KgLufcNhHuRhFT6alH6ur2VynfayTcgpff2Uc0/RS', 'frontend/profileImage/45/367312bad8f79cc5b45436128.png', 'frontend/profileCover/45/079970ac17b7efe6d198d400f.png', 1, 0, '', '', '', '2021-12-30 22:31:57', '1');

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE `verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `createAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `verification`
--

INSERT INTO `verification` (`id`, `user_id`, `code`, `status`, `createAt`) VALUES
(88, 42, 'b7445b9e7154bde6b91b72a57', '1', '2021-12-30 22:20:46'),
(89, 42, 'b7445b9e7154bde6b91b72a57', '1', '2021-12-30 22:20:58'),
(90, 43, '9cf8c79d1241c54f7392d966d', '1', '2021-12-30 22:23:22'),
(91, 43, '9cf8c79d1241c54f7392d966d', '1', '2021-12-30 22:23:31'),
(96, 45, 'fae5b904243ee65c02c9dbf00', '1', '2021-12-30 22:32:00'),
(97, 45, 'fae5b904243ee65c02c9dbf00', '1', '2021-12-30 22:32:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `commentBy` (`commentBy`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`followID`),
  ADD KEY `receiver` (`receiver`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeID`),
  ADD KEY `likeBy` (`likeBy`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `messageFrom` (`messageFrom`),
  ADD KEY `messageTo` (`messageTo`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notificationID`),
  ADD KEY `notificationFor` (`notificationFor`),
  ADD KEY `notificationFrom` (`notificationFrom`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profileForein` (`user_id`);

--
-- Indexes for table `retweet`
--
ALTER TABLE `retweet`
  ADD PRIMARY KEY (`retweetID`),
  ADD KEY `retweetBy` (`retweetBy`),
  ADD KEY `retweetFrom` (`retweetFrom`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tokenForein` (`user_id`);

--
-- Indexes for table `trends`
--
ALTER TABLE `trends`
  ADD PRIMARY KEY (`trendID`),
  ADD KEY `tweetID` (`tweetID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`tweetID`),
  ADD KEY `FK_foreign_tweets` (`tweetBy`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `verification`
--
ALTER TABLE `verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_foreign_verify` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `followID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `retweet`
--
ALTER TABLE `retweet`
  MODIFY `retweetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `trends`
--
ALTER TABLE `trends`
  MODIFY `trendID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `tweetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `verification`
--
ALTER TABLE `verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`commentBy`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`receiver`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`messageFrom`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`messageTo`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`notificationFor`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`notificationFrom`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profileForein` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `retweet`
--
ALTER TABLE `retweet`
  ADD CONSTRAINT `retweet_ibfk_1` FOREIGN KEY (`retweetBy`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `retweet_ibfk_2` FOREIGN KEY (`retweetFrom`) REFERENCES `tweets` (`tweetID`);

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `tokenForein` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `trends`
--
ALTER TABLE `trends`
  ADD CONSTRAINT `trends_ibfk_1` FOREIGN KEY (`tweetID`) REFERENCES `tweets` (`tweetID`),
  ADD CONSTRAINT `trends_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tweets`
--
ALTER TABLE `tweets`
  ADD CONSTRAINT `FK_foreign_tweets` FOREIGN KEY (`tweetBy`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `verification`
--
ALTER TABLE `verification`
  ADD CONSTRAINT `FK_foreign_verify` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
