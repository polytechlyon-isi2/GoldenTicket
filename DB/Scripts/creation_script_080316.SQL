/*
Created: 08/03/2016
Modified: 08/03/2016
Project: GoldenTicket
Model: MySQL 5.5
Database: MySQL 5.5
*/

-- Create tables section -------------------------------------------------

-- Table TicketsByOrder

CREATE TABLE TicketsByOrder
(
  num_ticket Int NOT NULL,
  num_order Int NOT NULL
)
;

ALTER TABLE TicketsByOrder ADD PRIMARY KEY (num_ticket,num_order)
;

-- Table Order

CREATE TABLE Order
(
  num_order Int NOT NULL AUTO_INCREMENT,
  num_user Int,
  status_order Varchar(20),
 PRIMARY KEY (num_order)
)
;

CREATE INDEX IX_Relationship20 ON Order (num_user)
;

-- Table PlaceCategory

CREATE TABLE PlaceCategory
(
  num_PC Int NOT NULL AUTO_INCREMENT,
  nom_PC Int,
  price_PC Int,
  initialNumberOfTicket_PC Int,
  actualNumberOfTickets Int,
  num_event Int,
 PRIMARY KEY (num_PC)
)
;

CREATE INDEX IX_Relationship3 ON PlaceCategory (num_event)
;

-- Table Ticket

CREATE TABLE Ticket
(
  num_ticket Int NOT NULL AUTO_INCREMENT,
  num_PC Int,
  numPlace_ticket Int,
  placement Varchar(20),
 PRIMARY KEY (num_ticket)
)
;

CREATE INDEX IX_Relationship4 ON Ticket (num_PC)
;

-- Table User

CREATE TABLE User
(
  num_user Int NOT NULL AUTO_INCREMENT,
  name_user Varchar(40),
  surname_user Varchar(40),
  login_user Varchar(40),
  password_user Varchar(40),
 PRIMARY KEY (num_user)
)
;

-- Table Status

CREATE TABLE Status
(
  num_status Int NOT NULL AUTO_INCREMENT,
  name_status Varchar(20),
 PRIMARY KEY (num_status)
)
;

-- Table Event

CREATE TABLE Event
(
  num_event Int NOT NULL AUTO_INCREMENT,
  minimalPrice_event Int,
  startDate_event Date,
  startHour_event Date,
  endDate_event Date,
  endHour_event Date,
  desc_event Text,
  num_status Int,
  num_ET Int,
 PRIMARY KEY (num_event)
)
;

CREATE INDEX IX_Relationship22 ON Event (num_status)
;

CREATE INDEX IX_Relationship23 ON Event (num_ET)
;

-- Table EventType

CREATE TABLE EventType
(
  num_ET Int NOT NULL AUTO_INCREMENT,
  name_ET Varchar(20),
 PRIMARY KEY (num_ET)
)
;

-- Create relationships section ------------------------------------------------- 

ALTER TABLE TicketsByOrder ADD CONSTRAINT Relationship18 FOREIGN KEY (num_ticket) REFERENCES Ticket (num_ticket) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Order ADD CONSTRAINT Relationship20 FOREIGN KEY (num_user) REFERENCES User (num_user) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE TicketsByOrder ADD CONSTRAINT Relationship19 FOREIGN KEY (num_order) REFERENCES Order (num_order) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Ticket ADD CONSTRAINT Relationship4 FOREIGN KEY (num_PC) REFERENCES PlaceCategory (num_PC) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Event ADD CONSTRAINT Relationship22 FOREIGN KEY (num_status) REFERENCES Status (num_status) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Event ADD CONSTRAINT Relationship23 FOREIGN KEY (num_ET) REFERENCES EventType (num_ET) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE PlaceCategory ADD CONSTRAINT Relationship3 FOREIGN KEY (num_event) REFERENCES Event (num_event) ON DELETE NO ACTION ON UPDATE NO ACTION
;


