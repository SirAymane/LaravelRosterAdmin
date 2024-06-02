-- Creem la taula, el usuari i li otorguem permissos al usuari

CREATE DATABASE leaguedb
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
  
USE leaguedb;

CREATE USER 'leagueusr'@'localhost' IDENTIFIED BY 'leaguepass';

GRANT ALL PRIVILEGES ON *.* TO 'leagueusr'@'localhost';

-- This part below is not executed. Added as reference
-- The migration is the one used to create the table


CREATE TABLE players (
    id INTEGER auto_increment,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    position INTEGER NOT NULL,
    salary DOUBLE NOT NULL,
    team_id INTEGER UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (team_id) REFERENCES teams(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE InnoDB;


CREATE TABLE teams (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    stadium VARCHAR(255) NOT NULL,
    numMembers VARCHAR(255) NOT NULL,
    budget DOUBLE NOT NULL,
    PRIMARY KEY (id)
) ENGINE InnoDB;
