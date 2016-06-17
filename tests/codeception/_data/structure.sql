SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `team_history`
--

DROP TABLE IF EXISTS `team_history`;
CREATE TABLE `team_history` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `speciality_id` int(11) DEFAULT NULL,
  `action` int(11) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_member`
--

DROP TABLE IF EXISTS `team_member`;
CREATE TABLE `team_member` (
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `speciality_id` int(11) DEFAULT NULL,
  `joined_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_member_role`
--

DROP TABLE IF EXISTS `team_member_role`;
CREATE TABLE `team_member_role` (
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_role`
--

DROP TABLE IF EXISTS `team_role`;
CREATE TABLE `team_role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_speciality`
--

DROP TABLE IF EXISTS `team_speciality`;
CREATE TABLE `team_speciality` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team_team`
--

DROP TABLE IF EXISTS `team_team`;
CREATE TABLE `team_team` (
  `id` int(11) NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `emblem` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `disbanded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `id`   int(11)                 NOT NULL,
    `name` VARCHAR(255)
           COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `team_history`
--
ALTER TABLE `team_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk__team_history__team` (`team_id`),
  ADD KEY `fk__team_history__user` (`user_id`),
  ADD KEY `fk__team_history__role` (`role_id`),
  ADD KEY `fk__team_history__speciality` (`speciality_id`);

--
-- Indexes for table `team_member`
--
ALTER TABLE `team_member`
  ADD PRIMARY KEY (`team_id`,`user_id`),
  ADD KEY `fk__team_member__user` (`user_id`),
  ADD KEY `fk__team_member__speciality` (`speciality_id`);

--
-- Indexes for table `team_member_role`
--
ALTER TABLE `team_member_role`
  ADD PRIMARY KEY (`team_id`,`user_id`,`role_id`),
  ADD KEY `fk__team_member_role__user` (`user_id`),
  ADD KEY `fk__team_member_role__role` (`role_id`);

--
-- Indexes for table `team_role`
--
ALTER TABLE `team_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_speciality`
--
ALTER TABLE `team_speciality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_team`
--
ALTER TABLE `team_team`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_slug` (`slug`),
  ADD KEY `fk__team_team__creator` (`creator_id`),
  ADD KEY `fk__team_team__owner` (`owner_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `team_history`
--
ALTER TABLE `team_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team_role`
--
ALTER TABLE `team_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team_speciality`
--
ALTER TABLE `team_speciality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `team_team`
--
ALTER TABLE `team_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `team_history`
--
ALTER TABLE `team_history`
  ADD CONSTRAINT `fk__team_history__role` FOREIGN KEY (`role_id`) REFERENCES `team_role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk__team_history__speciality` FOREIGN KEY (`speciality_id`) REFERENCES `team_speciality` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk__team_history__team` FOREIGN KEY (`team_id`) REFERENCES `team_team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk__team_history__user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_member`
--
ALTER TABLE `team_member`
  ADD CONSTRAINT `fk__team_member__speciality` FOREIGN KEY (`speciality_id`) REFERENCES `team_speciality` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk__team_member__team` FOREIGN KEY (`team_id`) REFERENCES `team_team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk__team_member__user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_member_role`
--
ALTER TABLE `team_member_role`
  ADD CONSTRAINT `fk__team_member_role__role` FOREIGN KEY (`role_id`) REFERENCES `team_role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk__team_member_role__team` FOREIGN KEY (`team_id`) REFERENCES `team_team` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk__team_member_role__user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_team`
--
ALTER TABLE `team_team`
  ADD CONSTRAINT `fk__team_team__creator` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk__team_team__owner` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
