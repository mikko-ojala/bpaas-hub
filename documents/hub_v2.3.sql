-- SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
-- SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `bpaashub` ;
CREATE SCHEMA IF NOT EXISTS `bpaashub` DEFAULT CHARACTER SET latin1 ;
USE `bpaashub` ;

-- -----------------------------------------------------
-- Table `bpaashub`.`AuthItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`AuthItem` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`AuthItem` (
  `name` VARCHAR(64) NOT NULL ,
  `type` INT(11) NOT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `bizrule` TEXT NULL DEFAULT NULL ,
  `data` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`name`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bpaashub`.`AuthAssignment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`AuthAssignment` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`AuthAssignment` (
  `itemname` VARCHAR(64) NOT NULL ,
  `userid` VARCHAR(64) NOT NULL ,
  `bizrule` TEXT NULL DEFAULT NULL ,
  `data` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`itemname`, `userid`) ,
  CONSTRAINT `AuthAssignment_ibfk_1`
    FOREIGN KEY (`itemname` )
    REFERENCES `bpaashub`.`AuthItem` (`name` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bpaashub`.`AuthItemChild`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`AuthItemChild` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`AuthItemChild` (
  `parent` VARCHAR(64) NOT NULL ,
  `child` VARCHAR(64) NOT NULL ,
  PRIMARY KEY (`parent`, `child`) ,
  INDEX `child` (`child` ASC) ,
  CONSTRAINT `AuthItemChild_ibfk_1`
    FOREIGN KEY (`parent` )
    REFERENCES `bpaashub`.`AuthItem` (`name` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `AuthItemChild_ibfk_2`
    FOREIGN KEY (`child` )
    REFERENCES `bpaashub`.`AuthItem` (`name` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bpaashub`.`Rights`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`Rights` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`Rights` (
  `itemname` VARCHAR(64) NOT NULL ,
  `type` INT(11) NOT NULL ,
  `weight` INT(11) NOT NULL ,
  PRIMARY KEY (`itemname`) ,
  CONSTRAINT `Rights_ibfk_1`
    FOREIGN KEY (`itemname` )
    REFERENCES `bpaashub`.`AuthItem` (`name` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bpaashub`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`users` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(20) NOT NULL ,
  `password` VARCHAR(128) NOT NULL ,
  `email` VARCHAR(128) NOT NULL ,
  `activkey` VARCHAR(128) NOT NULL DEFAULT '' ,
  `create_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `lastvisit_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `superuser` INT(1) NOT NULL DEFAULT '0' ,
  `status` INT(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username` (`username` ASC) ,
  UNIQUE INDEX `email` (`email` ASC) ,
  INDEX `status` (`status` ASC) ,
  INDEX `superuser` (`superuser` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bpaashub`.`profiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`profiles` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`profiles` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `lastname` VARCHAR(50) NOT NULL DEFAULT '' ,
  `firstname` VARCHAR(50) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`user_id`) ,
  CONSTRAINT `user_profile_id`
    FOREIGN KEY (`user_id` )
    REFERENCES `bpaashub`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bpaashub`.`profiles_fields`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`profiles_fields` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`profiles_fields` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `varname` VARCHAR(50) NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `field_type` VARCHAR(50) NOT NULL ,
  `field_size` VARCHAR(15) NOT NULL DEFAULT '0' ,
  `field_size_min` VARCHAR(15) NOT NULL DEFAULT '0' ,
  `required` INT(1) NOT NULL DEFAULT '0' ,
  `match` VARCHAR(255) NOT NULL DEFAULT '' ,
  `range` VARCHAR(255) NOT NULL DEFAULT '' ,
  `error_message` VARCHAR(255) NOT NULL DEFAULT '' ,
  `other_validator` VARCHAR(5000) NOT NULL DEFAULT '' ,
  `default` VARCHAR(255) NOT NULL DEFAULT '' ,
  `widget` VARCHAR(255) NOT NULL DEFAULT '' ,
  `widgetparams` VARCHAR(5000) NOT NULL DEFAULT '' ,
  `position` INT(3) NOT NULL DEFAULT '0' ,
  `visible` INT(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`) ,
  INDEX `varname` (`varname` ASC, `widget` ASC, `visible` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bpaashub`.`organisation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`organisation` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`organisation` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `create_at` TIMESTAMP NOT NULL DEFAULT NOW() ,
  `modified_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `deleted_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `active` TINYINT(1) NOT NULL DEFAULT 1 ,
  `system_active` TINYINT(1) NOT NULL DEFAULT 1 ,
  `name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bpaashub`.`organisation_profile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`organisation_profile` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`organisation_profile` (
  `name` VARCHAR(50) NOT NULL ,
  `address` VARCHAR(50) NOT NULL ,
  `description` TEXT NULL ,
  `organisation_id` INT(11) NOT NULL ,
  PRIMARY KEY (`organisation_id`) ,
  CONSTRAINT `fk_organisation_profile_organisation1`
    FOREIGN KEY (`organisation_id` )
    REFERENCES `bpaashub`.`organisation` (`id` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bpaashub`.`service`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`service` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`service` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(50) NOT NULL ,
  `create_at` TIMESTAMP NOT NULL DEFAULT NOW() ,
  `modified_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `deleted_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  `active` TINYINT(1) NOT NULL DEFAULT 1 ,
  `system_active` TINYINT(1) NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bpaashub`.`service_profile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`service_profile` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`service_profile` (
  `offer` INT(1) NOT NULL ,
  `description` TEXT NULL ,
  `service_id` INT(11) NOT NULL ,
  PRIMARY KEY (`service_id`) ,
  INDEX `fk_service_profile_service1_idx` (`service_id` ASC) ,
  CONSTRAINT `fk_service_profile_service1`
    FOREIGN KEY (`service_id` )
    REFERENCES `bpaashub`.`service` (`id` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bpaashub`.`service_organisation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`service_organisation` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`service_organisation` (
  `visibility` TINYINT NOT NULL ,
  `privacy` TINYINT NOT NULL ,
  `reserved1` TINYINT NOT NULL ,
  `reserved2` TINYINT NOT NULL ,
  `organisation_id` INT(11) NOT NULL ,
  `service_id` INT(11) NOT NULL ,
  PRIMARY KEY (`organisation_id`, `service_id`) ,
  INDEX `fk_service_organisation_service1_idx` (`service_id` ASC) ,
  CONSTRAINT `fk_service_organisation_organisation1`
    FOREIGN KEY (`organisation_id` )
    REFERENCES `bpaashub`.`organisation` (`id` )
    ON DELETE CASCADE
--    ON DELETE NO ACTION
    ON UPDATE RESTRICT,
--    ON UPDATE NO ACTION,
  CONSTRAINT `fk_service_organisation_service1`
    FOREIGN KEY (`service_id` )
    REFERENCES `bpaashub`.`service` (`id` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT
--    ON UPDATE NO ACTION
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bpaashub`.`organisation_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`organisation_users` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`organisation_users` (
  `visibility` TINYINT NOT NULL ,
  `privacy` TINYINT NOT NULL ,
  `owner` TINYINT NOT NULL ,
  `reserved1` TINYINT NOT NULL ,
  `reserved2` TINYINT NOT NULL ,
  `users_id` INT(11) NOT NULL ,
  `organisation_id` INT(11) NOT NULL ,
  PRIMARY KEY (`users_id`, `organisation_id`) ,
  INDEX `fk_organisation_users_organisation1_idx` (`organisation_id` ASC) ,
  CONSTRAINT `fk_organisation_users_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `bpaashub`.`users` (`id` )
    ON DELETE CASCADE
--    ON DELETE NO ACTION
    ON UPDATE RESTRICT,
--    ON UPDATE NO ACTION,
  CONSTRAINT `fk_organisation_users_organisation1`
    FOREIGN KEY (`organisation_id` )
    REFERENCES `bpaashub`.`organisation` (`id` )
    ON DELETE CASCADE
--    ON DELETE NO ACTION
    ON UPDATE RESTRICT
--    ON UPDATE NO ACTION
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bpaashub`.`service_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bpaashub`.`service_users` ;

CREATE  TABLE IF NOT EXISTS `bpaashub`.`service_users` (
  `visibility` TINYINT NOT NULL ,
  `privacy` TINYINT NOT NULL ,
  `owner` TINYINT NOT NULL ,
  `reserved1` TINYINT NOT NULL ,
  `reserved2` TINYINT NOT NULL ,
  `service_id` INT(11) NOT NULL ,
  `users_id` INT(11) NOT NULL ,
  PRIMARY KEY (`service_id`, `users_id`) ,
  INDEX `fk_service_users_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_service_users_service1`
    FOREIGN KEY (`service_id` )
    REFERENCES `bpaashub`.`service` (`id` )
    ON DELETE CASCADE
--    ON DELETE NO ACTION
    ON UPDATE RESTRICT,
--    ON UPDATE NO ACTION,
  CONSTRAINT `fk_service_users_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `bpaashub`.`users` (`id` )
    ON DELETE CASCADE
--    ON DELETE NO ACTION
    ON UPDATE RESTRICT
--    ON UPDATE NO ACTION
)
ENGINE = InnoDB;

USE `bpaashub` ;



INSERT INTO `users` (`id`, `username`, `password`, `email`, `activkey`, `superuser`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '9a24eff8c15a6a141ece27eb6947da0f', 1, 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', '099f825543f7850cc038b90aaff39fac', 0, 1);

INSERT INTO `profiles` (`user_id`, `lastname`, `firstname`) VALUES
(1, 'Admin', 'Administrator'),
(2, 'Demo', 'Demo');

INSERT INTO `profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3);

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, NULL, NULL, 'N;'),
('Authenticated', 2, NULL, NULL, 'N;'),
('Guest', 2, NULL, NULL, 'N;');


INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '1', NULL, 'N;');



-- SET SQL_MODE=@OLD_SQL_MODE;
-- SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
-- SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
