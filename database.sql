CREATE TABLE IF NOT EXISTS `album` (
 	`album_id` INT(11) NOT NULL AUTO_INCREMENT,
  	`name` VARCHAR(255) NOT NULL,
  	`description` TEXT NULL,
	`date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_add` DATETIME NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19;

INSERT INTO `album` (`album_id`, `name`, `description`, `date_upd`, `date_add`) VALUES
(1, '2019', 'album for anything related to fashion.', '2019-06-01 00:35:07', '2019-05-30 17:34:33'),
(2, '2020', 'Gadgets, drones and more.', '2020-06-01 00:35:07', '2020-05-30 17:34:33');

CREATE TABLE IF NOT EXISTS `image` (
    `image_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32) NOT NULL,
    `description` VARCHAR(200) NULL,
    `image` LONGBLOB NOT NULL,
    `size` VARCHAR(32) NULL,
    `extension` VARCHAR(32) NULL,
    `width` VARCHAR(32) NULL,
    `height` VARCHAR(32) NULL,
    `album_id` INT(11) NOT NULL,
    `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_add` DATETIME NOT NULL,
    PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 65;

INSERT INTO `image` (`image_id`, `name`, `description`, `image`, `size`, `extension`, `width`, `height`, `album_id`, `date_upd`, `date_add`) VALUES
(1, 'img001', 'descripcion de prueba 1', '', '1MB', 'jpg', '950', '600', 1, '2019-06-01 00:35:07', '2019-05-30 17:34:33'),
(2, 'img002', 'descripcion de prueba 2', '', '3MB', 'png', '1280', '720', 2, '2019-06-01 00:35:07', '2019-05-30 17:34:33');
