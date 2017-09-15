CREATE TABLE dnevnik (
  korisnik varchar(20) NOT NULL DEFAULT '',
  adresa varchar(30) NOT NULL DEFAULT '',
  skripta varchar(255) NOT NULL DEFAULT '',
  tekst varchar(255) NOT NULL DEFAULT '',
  preglednik varchar(255) NOT NULL DEFAULT '',
  vrijeme timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

