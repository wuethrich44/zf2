-- Create subjects table
CREATE TABLE IF NOT EXISTS `subjects` (
  `subjectID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(90) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(90) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`subjectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=343 ;

-- Create categories table
CREATE TABLE IF NOT EXISTS `categories` (
  `categoryID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- Create files table
CREATE TABLE IF NOT EXISTS `files` (
  `fileID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subjectID` int(11) unsigned NOT NULL,
  `categoryID` int(11) unsigned NOT NULL,
  `fileName` text COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `downloadCount` int(10) unsigned NOT NULL,
  PRIMARY KEY (`fileID`),
  KEY `subjectID` (`subjectID`),
  KEY `categoryID` (`categoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=166 ;

-- Create user table
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- Create user_registration table
CREATE TABLE IF NOT EXISTS `user_registration` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(16) NOT NULL,
  `request_time` datetime NOT NULL,
  `responded` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `token_UNIQUE` (`token`),
  CONSTRAINT `user_registration_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8