SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `swc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `swc` ;

-- -----------------------------------------------------
-- Table `swc`.`user_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swc`.`user_type` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(100) NULL,
  `shortcut` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `swc`.`track`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swc`.`track` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL,
  `identifier` VARCHAR(500) NULL,
  `objectives` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `swc`.`questions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swc`.`questions` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `question` TEXT NULL,
  `grade` INT NOT NULL,
  `track_id` BIGINT(20) NOT NULL,
  `identifier` VARCHAR(500) NULL,
  PRIMARY KEY (`id`, `track_id`),
  INDEX `fk_questions_track1_idx` (`track_id` ASC),
  CONSTRAINT `fk_questions_track1`
    FOREIGN KEY (`track_id`)
    REFERENCES `swc`.`track` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `swc`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swc`.`users` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NULL,
  `password` VARCHAR(200) NULL,
  `identifier` VARCHAR(500) NULL,
  `mail` VARCHAR(1000) NULL,
  `user_type_id` BIGINT(20) NOT NULL,
  `grade` VARCHAR(45) NULL,
  `track_id` BIGINT(20) NOT NULL,
  `questions_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`, `user_type_id`, `track_id`, `questions_id`),
  INDEX `fk_users_user_type_idx` (`user_type_id` ASC),
  INDEX `fk_users_track1_idx` (`track_id` ASC),
  INDEX `fk_users_questions1_idx` (`questions_id` ASC),
  CONSTRAINT `fk_users_user_type`
    FOREIGN KEY (`user_type_id`)
    REFERENCES `swc`.`user_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_track1`
    FOREIGN KEY (`track_id`)
    REFERENCES `swc`.`track` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_questions1`
    FOREIGN KEY (`questions_id`)
    REFERENCES `swc`.`questions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `swc`.`Answers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swc`.`Answers` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `answer` TEXT NULL,
  `identifier` VARCHAR(500) NULL,
  `status` TINYINT(1) NULL,
  `questions_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`, `questions_id`),
  INDEX `fk_Answers_questions1_idx` (`questions_id` ASC),
  CONSTRAINT `fk_Answers_questions1`
    FOREIGN KEY (`questions_id`)
    REFERENCES `swc`.`questions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `swc`.`track_aticls`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `swc`.`track_aticls` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(2000) NULL,
  `content` TEXT NULL,
  `identifier` VARCHAR(45) NULL,
  `track_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`, `track_id`),
  INDEX `fk_track_aticls_track1_idx` (`track_id` ASC),
  CONSTRAINT `fk_track_aticls_track1`
    FOREIGN KEY (`track_id`)
    REFERENCES `swc`.`track` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
