CREATE TABLE `cteachers` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `tname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(20) DEFAULT NULL,
  `updated_at` int(20) DEFAULT NULL,
  `deleted_at` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci