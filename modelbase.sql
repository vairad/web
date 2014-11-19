-- MySQL Script generated by MySQL Workbench
-- 11/13/14 13:58:29
-- Model: New Model    Version: 1.0
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`opravneni`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`opravneni` (
  `id_opravneni` INT NOT NULL,
  `nazev` VARCHAR(45) NULL,
  `popis` VARCHAR(1000) NULL,
  PRIMARY KEY (`id_opravneni`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`osoby`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`osoby` (
  `id_osoby` INT NOT NULL,
  `jmeno` VARCHAR(45) NULL,
  `prijmeni` VARCHAR(45) NULL,
  `prezdivka` VARCHAR(45) NULL,
  `datnar` DATE NULL,
  `pohlavi` TINYINT(1) NULL,
  `email` VARCHAR(60) NULL,
  `mobil` INT NULL,
  `heslo` VARCHAR(40) NULL,
  `posledni` DATETIME NULL,
  `vytvoreni` DATETIME NULL,
  `typuctu` INT NOT NULL,
  PRIMARY KEY (`id_osoby`),
  INDEX `fk_osoby_opravneni1_idx` (`typuctu` ASC),
  CONSTRAINT `fk_osoby_opravneni1`
    FOREIGN KEY (`typuctu`)
    REFERENCES `mydb`.`opravneni` (`id_opravneni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`hry`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`hry` (
  `id_hry` INT NOT NULL,
  `nazev` VARCHAR(60) NULL,
  `popis` TEXT NULL,
  `delka` INT NULL,
  `cena` INT NULL,
  `pocet_m` INT NULL,
  `pocet_z` INT NULL,
  `pocet_h` INT NULL,
  `min` INT NULL,
  `organizator` INT NOT NULL,
  PRIMARY KEY (`id_hry`),
  INDEX `fk_hry_osoby1_idx` (`organizator` ASC),
  CONSTRAINT `fk_hry_osoby1`
    FOREIGN KEY (`organizator`)
    REFERENCES `mydb`.`osoby` (`id_osoby`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`mista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`mista` (
  `id_mista` INT NOT NULL,
  `nazev` VARCHAR(60) NULL,
  `ulice` VARCHAR(100) NULL,
  `cp` INT NULL,
  `gps` VARCHAR(45) NULL,
  `popis` TEXT NULL,
  `kapacita` INT NULL,
  PRIMARY KEY (`id_mista`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`rocnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`rocnik` (
  `id_rocnik` INT NOT NULL,
  `zacatek` DATE NULL,
  `konec` DATE NULL,
  PRIMARY KEY (`id_rocnik`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`uvedeni`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`uvedeni` (
  `id_uvedeni` INT NOT NULL,
  `zacatek` DATETIME NULL,
  `misto` INT NOT NULL,
  `rocnik` INT NOT NULL,
  `hra` INT NOT NULL,
  PRIMARY KEY (`id_uvedeni`),
  INDEX `fk_uvedeni_mista1_idx` (`misto` ASC),
  INDEX `fk_uvedeni_rocnik1_idx` (`rocnik` ASC),
  INDEX `fk_uvedeni_hry1_idx` (`hra` ASC),
  CONSTRAINT `fk_uvedeni_mista1`
    FOREIGN KEY (`misto`)
    REFERENCES `mydb`.`mista` (`id_mista`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_uvedeni_rocnik1`
    FOREIGN KEY (`rocnik`)
    REFERENCES `mydb`.`rocnik` (`id_rocnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_uvedeni_hry1`
    FOREIGN KEY (`hra`)
    REFERENCES `mydb`.`hry` (`id_hry`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`prihlasky`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`prihlasky` (
  `cas` DATETIME NULL,
  `hrac` INT NOT NULL,
  `uvedeni` INT NOT NULL,
  PRIMARY KEY (`hrac`, `uvedeni`),
  INDEX `fk_prihlasky_osoby_idx` (`hrac` ASC),
  INDEX `fk_prihlasky_uvedeni1_idx` (`uvedeni` ASC),
  CONSTRAINT `fk_prihlasky_osoby`
    FOREIGN KEY (`hrac`)
    REFERENCES `mydb`.`osoby` (`id_osoby`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_prihlasky_uvedeni1`
    FOREIGN KEY (`uvedeni`)
    REFERENCES `mydb`.`uvedeni` (`id_uvedeni`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`aktuality`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`aktuality` (
  `id_aktuality` INT NOT NULL,
  `nadpis` VARCHAR(45) NULL,
  `text` VARCHAR(1000) NULL,
  `datum` DATETIME NULL,
  `dulezitost` INT NULL,
  `autor` INT NOT NULL,
  PRIMARY KEY (`id_aktuality`),
  INDEX `fk_aktuality_osoby1_idx` (`autor` ASC),
  CONSTRAINT `fk_aktuality_osoby1`
    FOREIGN KEY (`autor`)
    REFERENCES `mydb`.`osoby` (`id_osoby`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`platby`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`platby` (
  `id_platby` INT NOT NULL,
  `cas` DATETIME NULL,
  `castka` VARCHAR(45) NULL,
  `rocnik` INT NOT NULL,
  `osoba` INT NOT NULL,
  PRIMARY KEY (`id_platby`),
  INDEX `fk_platby_rocnik1_idx` (`rocnik` ASC),
  INDEX `fk_platby_osoby1_idx` (`osoba` ASC),
  CONSTRAINT `fk_platby_rocnik1`
    FOREIGN KEY (`rocnik`)
    REFERENCES `mydb`.`rocnik` (`id_rocnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_platby_osoby1`
    FOREIGN KEY (`osoba`)
    REFERENCES `mydb`.`osoby` (`id_osoby`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
