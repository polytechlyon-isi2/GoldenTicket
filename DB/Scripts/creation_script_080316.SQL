/*
Created: 08/03/2016
Modified: 15/03/2016
Model: MySQL 5.5
Database: MySQL 5.5
*/

-- Create tables section -------------------------------------------------

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

-- Table Event

CREATE TABLE Event
(
  num_event Int NOT NULL AUTO_INCREMENT,
  event_name Varchar(100),
  minimalPrice_event Int,
  startDate_event Date,
  startHour_event Time,
  endDate_event Date,
  endHour_event Time,
  desc_event Text,
  num_status Int,
  num_ET Int,
  coverImage_event Varchar(100),
 PRIMARY KEY (num_event)
)
;

CREATE INDEX IX_Relationship22 ON Event (num_status)
;

CREATE INDEX IX_Relationship23 ON Event (num_ET)
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

-- Table EventType

CREATE TABLE EventType
(
  num_ET Int NOT NULL AUTO_INCREMENT,
  name_ET Varchar(20),
  EventCategoryID Int,
 PRIMARY KEY (num_ET)
)
;

CREATE INDEX IX_Relationship25 ON EventType (EventCategoryID)
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

-- Table Order_GD

CREATE TABLE Order_GD
(
  num_order Int NOT NULL AUTO_INCREMENT,
  num_user Int,
  status_order Varchar(20),
 PRIMARY KEY (num_order)
)
;

CREATE INDEX IX_Relationship20 ON Order_GD (num_user)
;

-- Table TicketsByOrder

CREATE TABLE TicketsByOrder
(
  num_ticket Int NOT NULL,
  num_order Int NOT NULL
)
;

ALTER TABLE TicketsByOrder ADD PRIMARY KEY (num_ticket,num_order)
;

-- Table Status

CREATE TABLE Status
(
  num_status Int NOT NULL AUTO_INCREMENT,
  name_status Varchar(20),
 PRIMARY KEY (num_status)
)
;

-- Table EventCategory

CREATE TABLE EventCategory
(
  EventCategoryID Int NOT NULL AUTO_INCREMENT,
  EventCategoryName Varchar(40),
 PRIMARY KEY (EventCategoryID)
)
;

-- Create relationships section ------------------------------------------------- 

ALTER TABLE PlaceCategory ADD CONSTRAINT Relationship3 FOREIGN KEY (num_event) REFERENCES Event (num_event) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Ticket ADD CONSTRAINT Relationship4 FOREIGN KEY (num_PC) REFERENCES PlaceCategory (num_PC) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE TicketsByOrder ADD CONSTRAINT Relationship18 FOREIGN KEY (num_ticket) REFERENCES Ticket (num_ticket) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE TicketsByOrder ADD CONSTRAINT Relationship19 FOREIGN KEY (num_order) REFERENCES Order_GD (num_order) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Order_GD ADD CONSTRAINT Relationship20 FOREIGN KEY (num_user) REFERENCES User (num_user) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Event ADD CONSTRAINT Relationship22 FOREIGN KEY (num_status) REFERENCES Status (num_status) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE Event ADD CONSTRAINT Relationship23 FOREIGN KEY (num_ET) REFERENCES EventType (num_ET) ON DELETE NO ACTION ON UPDATE NO ACTION
;

ALTER TABLE EventType ADD CONSTRAINT Relationship25 FOREIGN KEY (EventCategoryID) REFERENCES EventCategory (EventCategoryID) ON DELETE NO ACTION ON UPDATE NO ACTION
;


