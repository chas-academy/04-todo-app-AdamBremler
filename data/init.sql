DROP DATABASE IF EXISTS `todo-app-db`;

CREATE DATABASE `todo-app-db`;

USE `todo-app-db`;

DROP TABLE IF EXISTS `todos`;

CREATE TABLE `todos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `completed` enum('false', 'true') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `todos` (`title`, `created`, `completed`)
VALUES
  ('create a todo', now(), 'false'),
  ('do laundry', now(), 'false'),
  ('finish todo app', now(), 'false');