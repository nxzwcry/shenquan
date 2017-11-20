CREATE TABLE `students` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ename` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` int(20) DEFAULT NULL,
  `grade` int(5) DEFAULT '0',
  `agent` int(5) NOT NULL DEFAULT '1' COMMENT '销售顾问id',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) NOT NULL DEFAULT '0',
  `created_at` int(20) DEFAULT NULL,
  `updated_at` int(20) DEFAULT NULL,
  `deleted_at` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci