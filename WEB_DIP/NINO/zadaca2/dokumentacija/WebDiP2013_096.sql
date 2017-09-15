SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `WebDiP2013_096` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `WebDiP2013_096` ;

-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`tip_korisnika`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`tip_korisnika` (
  `idtipa` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(40) NOT NULL,
  `prioritet` INT NULL,
  PRIMARY KEY (`idtipa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`korisnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`korisnik` (
  `idkorisnika` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(20) NOT NULL,
  `prezime` VARCHAR(40) NOT NULL,
  `korisnicko` VARCHAR(20) NOT NULL,
  `lozinka` VARCHAR(20) NOT NULL,
  `adresa` VARCHAR(50) NOT NULL,
  `grad` VARCHAR(30) NULL,
  `email` VARCHAR(30) NULL,
  `tip` INT NOT NULL,
  PRIMARY KEY (`idkorisnika`),
  INDEX `fk_korisnik_tip_korisnika1_idx` (`tip` ASC),
  CONSTRAINT `fk_korisnik_tip_korisnika1`
    FOREIGN KEY (`tip`)
    REFERENCES `WebDiP2013_096`.`tip_korisnika` (`idtipa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`marka`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`marka` (
  `idmarke` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idmarke`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`vozilo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`vozilo` (
  `idvozila` INT NOT NULL AUTO_INCREMENT,
  `registracija` VARCHAR(15) NOT NULL,
  `vlasnik` INT NOT NULL,
  `marka` INT NOT NULL,
  PRIMARY KEY (`idvozila`),
  INDEX `fk_vozilo_korisnik1_idx` (`vlasnik` ASC),
  INDEX `fk_vozilo_marka1_idx` (`marka` ASC),
  CONSTRAINT `fk_vozilo_korisnik1`
    FOREIGN KEY (`vlasnik`)
    REFERENCES `WebDiP2013_096`.`korisnik` (`idkorisnika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vozilo_marka1`
    FOREIGN KEY (`marka`)
    REFERENCES `WebDiP2013_096`.`marka` (`idmarke`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`parking`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`parking` (
  `idparkinga` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  `brmjesta` INT NOT NULL,
  `vrijemenaplate` TIME NOT NULL,
  `sat` FLOAT NOT NULL,
  `cjelodnevna` FLOAT NOT NULL,
  `mjesecna` FLOAT NOT NULL,
  PRIMARY KEY (`idparkinga`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`pripada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`pripada` (
  `parking` INT NOT NULL,
  `zaposlenik` INT NOT NULL,
  `datumzaposljavanja` DATE NULL,
  PRIMARY KEY (`parking`, `zaposlenik`),
  INDEX `fk_parking_has_korisnik_korisnik1_idx` (`zaposlenik` ASC),
  INDEX `fk_parking_has_korisnik_parking_idx` (`parking` ASC),
  CONSTRAINT `fk_parking_has_korisnik_parking`
    FOREIGN KEY (`parking`)
    REFERENCES `WebDiP2013_096`.`parking` (`idparkinga`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_parking_has_korisnik_korisnik1`
    FOREIGN KEY (`zaposlenik`)
    REFERENCES `WebDiP2013_096`.`korisnik` (`idkorisnika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`karta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`karta` (
  `idkarte` INT NOT NULL AUTO_INCREMENT,
  `cijena` FLOAT NOT NULL,
  `pocetak` TIMESTAMP NULL,
  `kraj` DATETIME NULL,
  `vozilo` INT NOT NULL,
  `parking` INT NOT NULL,
  PRIMARY KEY (`idkarte`),
  INDEX `fk_karta_vozilo1_idx` (`vozilo` ASC),
  INDEX `fk_karta_parking1_idx` (`parking` ASC),
  CONSTRAINT `fk_karta_vozilo1`
    FOREIGN KEY (`vozilo`)
    REFERENCES `WebDiP2013_096`.`vozilo` (`idvozila`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_karta_parking1`
    FOREIGN KEY (`parking`)
    REFERENCES `WebDiP2013_096`.`parking` (`idparkinga`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`kazna`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`kazna` (
  `idkazne` INT NOT NULL AUTO_INCREMENT,
  `cijena` FLOAT NULL,
  `vrijeme` TIMESTAMP NULL,
  `vozilo` INT NOT NULL,
  `parking` INT NOT NULL,
  PRIMARY KEY (`idkazne`),
  INDEX `fk_kazna_vozilo1_idx` (`vozilo` ASC),
  INDEX `fk_kazna_parking1_idx` (`parking` ASC),
  CONSTRAINT `fk_kazna_vozilo1`
    FOREIGN KEY (`vozilo`)
    REFERENCES `WebDiP2013_096`.`vozilo` (`idvozila`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_kazna_parking1`
    FOREIGN KEY (`parking`)
    REFERENCES `WebDiP2013_096`.`parking` (`idparkinga`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`slike`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`slike` (
  `idslike` INT NOT NULL AUTO_INCREMENT,
  `slika` BLOB NOT NULL,
  `kazna` INT NOT NULL,
  PRIMARY KEY (`idslike`),
  INDEX `fk_slike_kazna1_idx` (`kazna` ASC),
  CONSTRAINT `fk_slike_kazna1`
    FOREIGN KEY (`kazna`)
    REFERENCES `WebDiP2013_096`.`kazna` (`idkazne`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2013_096`.`prijava`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2013_096`.`prijava` (
  `idprijave` INT NOT NULL AUTO_INCREMENT,
  `korisnik` INT NOT NULL,
  `status` TINYINT(1) NULL,
  `datum` TIMESTAMP NULL,
  PRIMARY KEY (`idprijave`),
  INDEX `fk_prijava_korisnik1_idx` (`korisnik` ASC),
  CONSTRAINT `fk_prijava_korisnik1`
    FOREIGN KEY (`korisnik`)
    REFERENCES `WebDiP2013_096`.`korisnik` (`idkorisnika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
