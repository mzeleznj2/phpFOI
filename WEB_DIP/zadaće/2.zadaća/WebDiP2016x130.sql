-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema WebDiP2016x130
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema WebDiP2016x130
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `WebDiP2016x130` DEFAULT CHARACTER SET utf8 ;
USE `WebDiP2016x130` ;

-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Tip`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Tip` (
  `idTip` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NULL,
  PRIMARY KEY (`idTip`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Korisnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Korisnik` (
  `idKorisnik` INT NOT NULL AUTO_INCREMENT,
  `korime` VARCHAR(45) NOT NULL,
  `sifra` VARCHAR(45) NOT NULL,
  `ime` VARCHAR(45) NOT NULL,
  `prezime` VARCHAR(45) NOT NULL,
  `adresa` VARCHAR(45) NOT NULL,
  `datRod` DATE NOT NULL,
  `email` VARCHAR(45) NULL,
  `status` TINYINT(1) NULL,
  `idTIP` INT NOT NULL,
  PRIMARY KEY (`idKorisnik`, `idTIP`),
  INDEX `fk_KORISNIK_TIP_idx` (`idTIP` ASC),
  CONSTRAINT `fk_KORISNIK_TIP`
    FOREIGN KEY (`idTIP`)
    REFERENCES `WebDiP2016x130`.`Tip` (`idTip`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Dnevnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Dnevnik` (
  `idDnevnik` INT NOT NULL AUTO_INCREMENT,
  `datumVrijeme` DATE NULL,
  `Poruka` VARCHAR(45) NULL,
  `Skripta` VARCHAR(45) NULL,
  `idKorisnik` INT NOT NULL,
  PRIMARY KEY (`idDnevnik`),
  INDEX `fk_Dnevnik_KORISNIK1_idx` (`idKorisnik` ASC),
  CONSTRAINT `fk_Dnevnik_KORISNIK1`
    FOREIGN KEY (`idKorisnik`)
    REFERENCES `WebDiP2016x130`.`Korisnik` (`idKorisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Statistika_lojalnosti`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Statistika_lojalnosti` (
  `idStatistika` INT NOT NULL AUTO_INCREMENT,
  `brojBodova` INT NULL,
  `datum` DATE NULL,
  `idKorisnik` INT NOT NULL,
  PRIMARY KEY (`idStatistika`, `idKorisnik`),
  INDEX `fk_Statistika_lojalnosti_KORISNIK1_idx` (`idKorisnik` ASC),
  CONSTRAINT `fk_Statistika_lojalnosti_KORISNIK1`
    FOREIGN KEY (`idKorisnik`)
    REFERENCES `WebDiP2016x130`.`Korisnik` (`idKorisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Dan_u_tjednu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Dan_u_tjednu` (
  `idDan` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NULL,
  PRIMARY KEY (`idDan`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Kupon`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Kupon` (
  `idKupon` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NULL,
  `pdf` VARCHAR(45) NULL,
  `video` VARCHAR(45) NULL,
  `slika` VARCHAR(45) NULL,
  `idKorisnik` INT NOT NULL,
  PRIMARY KEY (`idKupon`),
  INDEX `fk_Kupon_KORISNIK1_idx` (`idKorisnik` ASC),
  CONSTRAINT `fk_Kupon_KORISNIK1`
    FOREIGN KEY (`idKorisnik`)
    REFERENCES `WebDiP2016x130`.`Korisnik` (`idKorisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Vrste_vjezbe`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Vrste_vjezbe` (
  `idVrsta` INT NOT NULL AUTO_INCREMENT,
  `vrsta` VARCHAR(45) NULL,
  `idKorisnik` INT NOT NULL,
  PRIMARY KEY (`idVrsta`),
  INDEX `fk_Vrste_vjezbe_KORISNIK1_idx` (`idKorisnik` ASC),
  CONSTRAINT `fk_Vrste_vjezbe_KORISNIK1`
    FOREIGN KEY (`idKorisnik`)
    REFERENCES `WebDiP2016x130`.`Korisnik` (`idKorisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Program`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Program` (
  `idProgram` INT NOT NULL AUTO_INCREMENT,
  `mjesec` VARCHAR(45) NULL,
  `vrijeme` TIME NULL,
  `broj_polaznika` INT NULL,
  `zamjenski_termin` TIME NULL,
  `idDan` INT NOT NULL,
  `idKorisnik` INT NOT NULL,
  `idVrsta` INT NOT NULL,
  PRIMARY KEY (`idProgram`, `idDan`, `idKorisnik`, `idVrsta`),
  INDEX `fk_Program_Dan_u_tjednu1_idx` (`idDan` ASC),
  INDEX `fk_Program_KORISNIK1_idx` (`idKorisnik` ASC),
  INDEX `fk_Program_Vrste_vjezbe1_idx` (`idVrsta` ASC),
  CONSTRAINT `fk_Program_Dan_u_tjednu1`
    FOREIGN KEY (`idDan`)
    REFERENCES `WebDiP2016x130`.`Dan_u_tjednu` (`idDan`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Program_KORISNIK1`
    FOREIGN KEY (`idKorisnik`)
    REFERENCES `WebDiP2016x130`.`Korisnik` (`idKorisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Program_Vrste_vjezbe1`
    FOREIGN KEY (`idVrsta`)
    REFERENCES `WebDiP2016x130`.`Vrste_vjezbe` (`idVrsta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Polaznik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Polaznik` (
  `idProgram` INT NOT NULL,
  `idKorisnik` INT NOT NULL,
  PRIMARY KEY (`idProgram`, `idKorisnik`),
  INDEX `fk_Polaznik_KORISNIK1_idx` (`idKorisnik` ASC),
  CONSTRAINT `fk_Polaznik_Program1`
    FOREIGN KEY (`idProgram`)
    REFERENCES `WebDiP2016x130`.`Program` (`idProgram`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Polaznik_KORISNIK1`
    FOREIGN KEY (`idKorisnik`)
    REFERENCES `WebDiP2016x130`.`Korisnik` (`idKorisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Evidencija`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Evidencija` (
  `idEvidencija` INT NOT NULL AUTO_INCREMENT,
  `Dan_u_tjednu_idDan` INT NOT NULL,
  `Polaznik_idProgram` INT NOT NULL,
  `Polaznik_idKorisnik` INT NOT NULL,
  PRIMARY KEY (`idEvidencija`, `Dan_u_tjednu_idDan`, `Polaznik_idProgram`, `Polaznik_idKorisnik`),
  INDEX `fk_Evidencija_Dan_u_tjednu1_idx` (`Dan_u_tjednu_idDan` ASC),
  INDEX `fk_Evidencija_Polaznik1_idx` (`Polaznik_idProgram` ASC, `Polaznik_idKorisnik` ASC),
  CONSTRAINT `fk_Evidencija_Dan_u_tjednu1`
    FOREIGN KEY (`Dan_u_tjednu_idDan`)
    REFERENCES `WebDiP2016x130`.`Dan_u_tjednu` (`idDan`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Evidencija_Polaznik1`
    FOREIGN KEY (`Polaznik_idProgram` , `Polaznik_idKorisnik`)
    REFERENCES `WebDiP2016x130`.`Polaznik` (`idProgram` , `idKorisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Kupon_za_program`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Kupon_za_program` (
  `idProgram` INT NOT NULL,
  `idKupon` INT NOT NULL,
  `aktivan_od` TIME NULL,
  `aktivan_do` TIME NULL,
  `cijena` INT NULL,
  PRIMARY KEY (`idProgram`, `idKupon`),
  INDEX `fk_Program_has_Kupon_Kupon1_idx` (`idKupon` ASC),
  INDEX `fk_Program_has_Kupon_Program1_idx` (`idProgram` ASC),
  CONSTRAINT `fk_Program_has_Kupon_Program1`
    FOREIGN KEY (`idProgram`)
    REFERENCES `WebDiP2016x130`.`Program` (`idProgram`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Program_has_Kupon_Kupon1`
    FOREIGN KEY (`idKupon`)
    REFERENCES `WebDiP2016x130`.`Kupon` (`idKupon`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2016x130`.`Korisnik_kupon`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2016x130`.`Korisnik_kupon` (
  `idProgram` INT NOT NULL,
  `idKupon` INT NOT NULL,
  `idKorisnik` INT NOT NULL,
  `kod_kupon` VARCHAR(45) NULL,
  PRIMARY KEY (`idProgram`, `idKupon`, `idKorisnik`),
  INDEX `fk_Kupon_za_program_has_KORISNIK_KORISNIK1_idx` (`idKorisnik` ASC),
  INDEX `fk_Kupon_za_program_has_KORISNIK_Kupon_za_program1_idx` (`idProgram` ASC, `idKupon` ASC),
  CONSTRAINT `fk_Kupon_za_program_has_KORISNIK_Kupon_za_program1`
    FOREIGN KEY (`idProgram` , `idKupon`)
    REFERENCES `WebDiP2016x130`.`Kupon_za_program` (`idProgram` , `idKupon`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kupon_za_program_has_KORISNIK_KORISNIK1`
    FOREIGN KEY (`idKorisnik`)
    REFERENCES `WebDiP2016x130`.`Korisnik` (`idKorisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
