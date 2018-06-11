CREATE TABLE IF NOT EXISTS `beetest`.`user`(
 `user_id` int(11) NOT NULL AUTO_INCREMENT,
 `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
 `user_lastname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
 `user_password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
 `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
 `user_active` tinyint(1) NOT NULL DEFAULT '0',
 `is_admin` tinyint(1) NOT NULL DEFAULT '0',
 `user_activation_hash` varchar(255) NOT NULL,
 `user_creation_time` datetime NOT NULL,
 `user_last_login_timestamp` timestamp,
 PRIMARY KEY (`user_id`),
 UNIQUE KEY `user_name` (`user_name`),
 UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;