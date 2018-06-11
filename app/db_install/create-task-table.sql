CREATE TABLE IF NOT EXISTS `beetest`.`task` (
 `task_id` int(11) NOT NULL AUTO_INCREMENT,
 `task_name` varchar(64) COLLATE utf8_general_ci NOT NULL,
 `task_priority` tinyint(1) DEFAULT '1',
 `task_deadline` datetime DEFAULT NULL,
 `task_completed` tinyint(1) DEFAULT '0',
 `image` varchar(64),
 `description` varchar(255) DEFAULT '',
 `user_id` int(11) NOT NULL,
 PRIMARY KEY (`task_id`),
 FOREIGN KEY (user_id)
	REFERENCES user(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
