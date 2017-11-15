CREATE TABLE `recharge` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `cid` int(5) NOT NULL DEFAULT '1' COMMENT '1:kk 2:辅导君',
  `lessons` int(5) NOT NULL DEFAULT '0' COMMENT '外教一对一',
  `lessons1` int(5) NOT NULL DEFAULT '0' COMMENT '中教课时',
  `lessons2` int(5) NOT NULL DEFAULT '0' COMMENT '外教精品课',
  `money` int(10) DEFAULT NULL,
  `sid` int(10) NOT NULL,
  `note` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(20) NOT NULL,
  `updated_at` int(20) NOT NULL,
  `deleted_at` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci