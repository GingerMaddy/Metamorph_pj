-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 21, 2025 at 04:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

-- Database: `Metamorph`
//TODO: aggiornare SQL
-- Struttura della tabella `Celle`
CREATE TABLE `Celle` (
  `obsv_id` int(11) NOT NULL AUTO_INCREMENT,  -- Identificatore unico per ogni osservazione
  `cell_id` int(11) NOT NULL                  -- Identificatore per ogni cella
  `temperature` float NOT NULL,               -- Temperatura nella cella
  `humidity` float NOT NULL,                  -- Livello di umidità nella cella
  `food` varchar(100) NOT NULL,               -- Tipologia di cibo nella cella
  `date` datetime NOT NULL,                   -- Data di osservazione
  `larvae_count` int(11) NOT NULL,           -- Conteggio delle larve
  `pupae_count` int(11) NOT NULL,            -- Conteggio delle pupe
  `adult_count` int(11) NOT NULL,            -- Conteggio degli adulti
  `total_individuals` int(11) NOT NULL,      -- Totale degli individui conteggiati
  `total_female` int(11) NOT NULL,           -- Totale degli individui femmina
  `total_male` int(11) NOT NULL              -- Totale degli individui maschio
    PRIMARY KEY (`obsv_id`);              
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Struttura della tabella `Lepidoptera`
CREATE TABLE `Lepidoptera` (
  `lep_id` int(11) NOT NULL AUTO_INCREMENT,   -- Identificatore unico per ogni Lepidoptera
  `species` varchar(45) NOT NULL,              -- Nome della specie
  `sex` enum('maschio','femmina','sconosciuto') NOT NULL, -- Genere
  `stage` enum('uovo','larva','crisalide','adulto') NOT NULL, -- Stadio di sviluppo
  `weight` float NOT NULL,                     -- Peso del Lepidoptera
  `length` float NOT NULL,                     -- Lunghezza del Lepidoptera
  `user_id` int(11) NOT NULL,                 -- Riferimento all'utente che lo ha registrato
  `obsv_id` int(11) NOT NULL,                   -- Riferimento alla osservazio in cui è stato trovato
  PRIMARY KEY (`lep_id`),                       -- Set lep_id as the primary key
  KEY `FK_1` (`user_id`),                       -- Index for user_id
  KEY `FK_2` (`obsv_id`)                    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Struttura della tabella `Users`
--//TODO: controllo aggiunta ruolo utente, che stabilisce le operazioni che può fare
CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,   -- Identificatore unico per ogni utente
  `username` varchar(45) NOT NULL,              -- Nome utente per il login
  `password` varchar(255) NOT NULL,             -- Password hashata
  `role` enum('Amministratore','Tecnico','Studente') NOT NULL, -- Ruolo utente
  PRIMARY KEY (`user_id`);
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--impostazione delle chiavi esterne
-- Aggiunta delle vincoli di chiave esterna
ALTER TABLE `Lepidoptera`
  ADD CONSTRAINT `FK_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `FK_2` FOREIGN KEY (`obsv_id`) REFERENCES `Celle` (`obsv_id`);
