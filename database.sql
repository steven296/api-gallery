CREATE TABLE IF NOT EXISTS `image` (
    `image_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32) NOT NULL,
    `description` VARCHAR(200) NULL,
    `image` LONGBLOB NOT NULL,
    `size` VARCHAR(32) NULL,
    `extension` VARCHAR(32) NULL,
    `width` VARCHAR(32) NULL,
    `height` VARCHAR(32) NULL,
    `date_upd` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_add` DATETIME NOT NULL,
    PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 65;

INSERT INTO `image` (`image_id`, `name`, `description`, `image`, `size`, `extension`, `width`, `height`, `date_upd`, `date_add`) VALUES
(1, 'img001', 'descripcion de prueba 1', '', '1MB', 'jpg', '950', '600', '2019-06-01 00:35:07', '2019-05-30 17:34:33'),
(2, 'img002', 'descripcion de prueba 2', '', '3MB', 'png', '1280', '720', '2019-06-01 00:35:07', '2019-05-30 17:34:33');
