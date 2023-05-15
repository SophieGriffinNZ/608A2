CREATE DATABASE IF NOT EXISTS motueka;
USE motueka;

-- The rooms for the bed and breakfast
DROP TABLE IF EXISTS room;
CREATE TABLE IF NOT EXISTS room (
  roomID int unsigned NOT NULL auto_increment,
  roomname varchar(100) NOT NULL,
  description text default NULL,
  roomtype character default 'D',  
  beds int,
  PRIMARY KEY (roomID)
) AUTO_INCREMENT=1;
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (1,"Kellie","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing","S",5);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (2,"Herman","Lorem ipsum dolor sit amet, consectetuer","D",5);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (3,"Scarlett","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur","D",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (4,"Jelani","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam","S",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (5,"Sonya","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.","S",5);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (6,"Miranda","Lorem ipsum dolor sit amet, consectetuer adipiscing","S",4);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (7,"Helen","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.","S",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (8,"Octavia","Lorem ipsum dolor sit amet,","D",3);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (9,"Gretchen","Lorem ipsum dolor sit","D",3);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (10,"Bernard","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer","S",5);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (11,"Dacey","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur","D",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (12,"Preston","Lorem","D",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (13,"Dane","Lorem ipsum dolor","S",4);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (14,"Cole","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam","S",1);

-- Customers
DROP TABLE IF EXISTS customer;
CREATE TABLE IF NOT EXISTS customer (
  customerID int unsigned NOT NULL auto_increment,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(40) NOT NULL default '.',
  PRIMARY KEY (customerID)
) AUTO_INCREMENT=1;

INSERT INTO customer (customerID,firstname,lastname,email) VALUES 
(2,"Desiree","Collier","Maecenas@non.co.uk"),
(3,"Irene","Walker","id.erat.Etiam@id.org"),
(4,"Forrest","Baldwin","eget.nisi.dictum@a.com"),
(5,"Beverly","Sellers","ultricies.sem@pharetraQuisqueac.co.uk"),
(6,"Glenna","Kinney","dolor@orcilobortisaugue.org"),
(7,"Montana","Gallagher","sapien.cursus@ultriciesdignissimlacus.edu"),(8,"Harlan","Lara","Duis@aliquetodioEtiam.edu"),
(9,"Benjamin","King","mollis@Nullainterdum.org"),
(10,"Rajah","Olsen","Vestibulum.ut.eros@nequevenenatislacus.ca"),
(11,"Castor","Kelly","Fusce.feugiat.Lorem@porta.co.uk"),
(12,"Omar","Oconnor","eu.turpis@auctorvelit.co.uk"),
(13,"Porter","Leonard","dui.Fusce@accumsanlaoreet.net"),
(14,"Buckminster","Gaines","convallis.convallis.dolor@ligula.co.uk"),
(15,"Hunter","Rodriquez","ridiculus.mus.Donec@est.co.uk"),
(16,"Zahir","Harper","vel@estNunc.com"),
(17,"Sopoline","Warner","vestibulum.nec.euismod@sitamet.co.uk"),
(18,"Burton","Parrish","consequat.nec.mollis@nequenonquam.org"),
(19,"Abbot","Rose","non@et.ca"),
(20,"Barry","Burks","risus@libero.net");

-- Bookings
DROP TABLE IF EXISTS bookings;
CREATE TABLE IF NOT EXISTS bookings (
  bookingID int unsigned NOT NULL auto_increment,
  roomID int unsigned NOT NULL,
  checkIN varchar(10)  NOT NULL,
  checkOUT varchar(10) NOT NULL,
  customerID int unsigned NOT NULL,
  contactNumber varchar(15) NOT NULL,
  extras varchar(100),
  roomReview varchar(100),
  PRIMARY KEY (bookingID),
  FOREIGN KEY (roomID) REFERENCES room(roomID),
  FOREIGN KEY (customerID) REFERENCES customer(customerID)
) AUTO_INCREMENT=1;

INSERT INTO bookings (bookingID,roomID,checkIN,checkOUT,customerID,contactNumber,extras,roomReview) VALUES 
(2,1,"02/04/2023","06/04/2023",4,"0276841168","Extra towels","Great view and comfortable bed"),
(3,6,"15/06/2024","20/06/2024",5,"034586672","Natural Shampoo"," "),
(4,9,"08/08/2024","10/08/2024",6,"0224865924","Breakfast at 7am"," "),
(5,8,"25/10/2024","28/10/2024",14,"046638972","Late check in at 9pm"," ");