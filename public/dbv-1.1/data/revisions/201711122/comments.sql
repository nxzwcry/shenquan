ALTER TABLE `courses` CHANGE `class_id` `class_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `lessons` CHANGE `class_id` `class_id` INT(11) NOT NULL DEFAULT '0';