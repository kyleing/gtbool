alter table user rename to users;

ALTER TABLE `article` ADD `tag` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标签' AFTER `title`

ALTER TABLE `tag` CHANGE `name` `name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标签名';