-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2024 at 09:14 AM
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
-- Database: `digidate`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dislikes`
--

CREATE TABLE `tbl_dislikes` (
  `dislikes_id` int(11) NOT NULL,
  `dislikes_disliked_user` int(11) NOT NULL,
  `dislikes_current_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_education`
--

CREATE TABLE `tbl_education` (
  `education_id` int(11) NOT NULL,
  `education_name` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE `tbl_images` (
  `images_id` int(11) NOT NULL,
  `images_user_id` int(11) NOT NULL,
  `images_image` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_languages`
--

CREATE TABLE `tbl_languages` (
  `languages_id` int(11) NOT NULL,
  `languages_name` varchar(58) NOT NULL,
  `languages_code` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_likes`
--

CREATE TABLE `tbl_likes` (
  `likes_id` int(11) NOT NULL,
  `likes_liked_user` int(11) NOT NULL,
  `likes_current_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `messages_id` int(11) NOT NULL,
  `messages_sender` int(11) NOT NULL,
  `messages_reciever` int(11) NOT NULL,
  `messages_message` varchar(255) NOT NULL,
  `messages_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tags`
--

CREATE TABLE `tbl_tags` (
  `tags_id` int(11) NOT NULL,
  `tags_title` varchar(255) NOT NULL,
  `tags_color` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `users_id` int(11) NOT NULL,
  `users_first_name` varchar(50) DEFAULT NULL,
  `users_preposition` varchar(10) DEFAULT NULL,
  `users_last_name` varchar(50) DEFAULT NULL,
  `users_email` varchar(255) NOT NULL,
  `users_password` varchar(255) NOT NULL,
  `users_city` varchar(50) DEFAULT NULL,
  `users_phonenumber` int(15) DEFAULT NULL,
  `users_date_of_birth` date DEFAULT NULL,
  `users_gender` varchar(10) DEFAULT NULL,
  `users_description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_education`
--

CREATE TABLE `tbl_users_education` (
  `users_education_id` int(11) NOT NULL,
  `users_education_users_id` int(2) NOT NULL,
  `users_education_education_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_languages`
--

CREATE TABLE `tbl_users_languages` (
  `users_langauges_id` int(11) NOT NULL,
  `user_languages_users_id` int(3) NOT NULL,
  `user_languages_languages_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usertags`
--

CREATE TABLE `tbl_usertags` (
  `usertags_id` int(11) NOT NULL,
  `usertags_users_id` int(11) NOT NULL,
  `usertags_tags_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_dislikes`
--
ALTER TABLE `tbl_dislikes`
  ADD PRIMARY KEY (`dislikes_id`),
  ADD KEY `dislikes_disliked_user` (`dislikes_disliked_user`,`dislikes_current_user`),
  ADD KEY `dislikes_current_user` (`dislikes_current_user`);

--
-- Indexes for table `tbl_education`
--
ALTER TABLE `tbl_education`
  ADD PRIMARY KEY (`education_id`);

--
-- Indexes for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD PRIMARY KEY (`images_id`),
  ADD KEY `images_user_id` (`images_user_id`);

--
-- Indexes for table `tbl_languages`
--
ALTER TABLE `tbl_languages`
  ADD PRIMARY KEY (`languages_id`);

--
-- Indexes for table `tbl_likes`
--
ALTER TABLE `tbl_likes`
  ADD PRIMARY KEY (`likes_id`),
  ADD KEY `likes_liked_user` (`likes_liked_user`,`likes_current_user`),
  ADD KEY `likes_current_user` (`likes_current_user`);

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`messages_id`),
  ADD KEY `messages_sender` (`messages_sender`,`messages_reciever`),
  ADD KEY `messages_reciever` (`messages_reciever`);

--
-- Indexes for table `tbl_tags`
--
ALTER TABLE `tbl_tags`
  ADD PRIMARY KEY (`tags_id`),
  ADD KEY `tags_id` (`tags_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`users_id`);

--
-- Indexes for table `tbl_users_education`
--
ALTER TABLE `tbl_users_education`
  ADD PRIMARY KEY (`users_education_id`),
  ADD KEY `users_education_users_id` (`users_education_users_id`,`users_education_education_id`),
  ADD KEY `users_education_education_id` (`users_education_education_id`);

--
-- Indexes for table `tbl_users_languages`
--
ALTER TABLE `tbl_users_languages`
  ADD PRIMARY KEY (`users_langauges_id`),
  ADD KEY `user_languages_users_id` (`user_languages_users_id`,`user_languages_languages_id`),
  ADD KEY `user_languages_languages_id` (`user_languages_languages_id`);

--
-- Indexes for table `tbl_usertags`
--
ALTER TABLE `tbl_usertags`
  ADD KEY `usertags_users_id` (`usertags_users_id`),
  ADD KEY `usertags_tags_id` (`usertags_tags_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_dislikes`
--
ALTER TABLE `tbl_dislikes`
  MODIFY `dislikes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_education`
--
ALTER TABLE `tbl_education`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `images_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_languages`
--
ALTER TABLE `tbl_languages`
  MODIFY `languages_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_likes`
--
ALTER TABLE `tbl_likes`
  MODIFY `likes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `messages_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tags`
--
ALTER TABLE `tbl_tags`
  MODIFY `tags_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users_education`
--
ALTER TABLE `tbl_users_education`
  MODIFY `users_education_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users_languages`
--
ALTER TABLE `tbl_users_languages`
  MODIFY `users_langauges_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_dislikes`
--
ALTER TABLE `tbl_dislikes`
  ADD CONSTRAINT `tbl_dislikes_ibfk_1` FOREIGN KEY (`dislikes_disliked_user`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_dislikes_ibfk_2` FOREIGN KEY (`dislikes_current_user`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD CONSTRAINT `tbl_images_ibfk_1` FOREIGN KEY (`images_user_id`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_likes`
--
ALTER TABLE `tbl_likes`
  ADD CONSTRAINT `tbl_likes_ibfk_1` FOREIGN KEY (`likes_current_user`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_likes_ibfk_2` FOREIGN KEY (`likes_liked_user`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD CONSTRAINT `tbl_messages_ibfk_1` FOREIGN KEY (`messages_sender`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_messages_ibfk_2` FOREIGN KEY (`messages_reciever`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_users_education`
--
ALTER TABLE `tbl_users_education`
  ADD CONSTRAINT `tbl_users_education_ibfk_1` FOREIGN KEY (`users_education_users_id`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_users_education_ibfk_2` FOREIGN KEY (`users_education_education_id`) REFERENCES `tbl_education` (`education_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_users_languages`
--
ALTER TABLE `tbl_users_languages`
  ADD CONSTRAINT `tbl_users_languages_ibfk_1` FOREIGN KEY (`user_languages_users_id`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_users_languages_ibfk_2` FOREIGN KEY (`user_languages_languages_id`) REFERENCES `tbl_languages` (`languages_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_usertags`
--
ALTER TABLE `tbl_usertags`
  ADD CONSTRAINT `tbl_usertags_ibfk_1` FOREIGN KEY (`usertags_users_id`) REFERENCES `tbl_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_usertags_ibfk_2` FOREIGN KEY (`usertags_tags_id`) REFERENCES `tbl_tags` (`tags_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
