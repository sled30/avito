-- MySQL Script generated by MySQL Workbench
-- Вс 21 апр 2019 20:28:13
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mydb` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
SHOW WARNINGS;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `location`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `location` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `location` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idsity` INT NULL,
  `rejion` VARCHAR(45) NULL,
  `sity` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `address` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `address` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sity` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `type_auto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `type_auto` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `type_auto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `typeauto` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `title`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `title` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `title` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `parametr_auto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `parametr_auto` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `parametr_auto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(25) NULL,
  `owners` VARCHAR(4) NULL,
  `type_avto` VARCHAR(15) NULL,
  `doors` INT NULL,
  `power` INT NULL,
  `type_power` VARCHAR(10) NULL,
  `run` INT NULL,
  `color` VARCHAR(25) NULL,
  `drive` VARCHAR(10) NULL,
  `rulel` VARCHAR(7) NULL,
  `good` VARCHAR(10) NULL,
  `vin` VARCHAR(19) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bye`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bye` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `bye` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `location` INT NOT NULL,
  `address` INT NOT NULL,
  `create_date` INT NULL,
  `type_auto_idtable1` INT NOT NULL,
  `price` VARCHAR(10) NULL,
  `phone` VARCHAR(14) NULL,
  `id_title` INT NOT NULL,
  `load` TIMESTAMP NOT NULL,
  `description` BLOB NULL,
  `parametr_auto` INT NOT NULL,
  `id_order` INT NULL,
  `seler` VARCHAR(45) NULL,
  `status` VARCHAR(45) NULL,
  `date_close` VARCHAR(45) NULL,
  PRIMARY KEY (`id`, `location`, `address`, `type_auto_idtable1`, `id_title`, `parametr_auto`))
ENGINE = InnoDB
COMMENT = '						';

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `pictures`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pictures` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `pictures` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `one` VARCHAR(46) NULL,
  `too` VARCHAR(46) NULL,
  `second` VARCHAR(46) NULL,
  `three` VARCHAR(46) NULL,
  `foo` VARCHAR(46) NULL,
  `id_order` INT NOT NULL,
  `by_location_idlocation` INT NOT NULL,
  `by_address_idaddress` INT NOT NULL,
  `by_type_auto_idtable1` INT NOT NULL,
  PRIMARY KEY (`id`, `id_order`, `by_location_idlocation`, `by_address_idaddress`, `by_type_auto_idtable1`))
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `id_order` ON `pictures` (`id_order` ASC);

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
