#!/bin/bash

DB=""
if [[ $# != 1 ]];
then
        echo "Please pass the DB name"
        exit 0
else
        DB=$1
fi

mysql -u gaabe -pgaabe  << EOF

DROP DATABASE IF EXISTS $DB;
CREATE DATABASE $DB;
USE $DB;


DROP TABLE IF EXISTS user_payment;
DROP TABLE IF EXISTS booking;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS product_category;
DROP TABLE IF EXISTS donation_paied;
/*DROP TABLE IF EXISTS user_role_lk;*/
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS user_status;
DROP TABLE IF EXISTS calendar;
DROP TABLE IF EXISTS donation;
DROP TABLE IF EXISTS role;

DROP TABLE IF EXISTS role;
CREATE TABLE role (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(150) default NULL,
  description text,
  PRIMARY KEY (id),
  UNIQUE KEY name (name)
) TYPE=INNODB;

insert into role(name, description) values 
('admin','role with administratio rights'),
('user','role with normal user rights');

DROP TABLE IF EXISTS donation_type;
CREATE TABLE donation_type (
  id int(10) unsigned NOT NULL auto_increment,
  type varchar(50) default NULL,
  PRIMARY KEY (id),
  UNIQUE KEY type (type)
) TYPE=INNODB;

insert into donation_type(type) values 
('ridotta'),
('ordinaria'),
('sostenitore');

DROP TABLE IF EXISTS donation;
CREATE TABLE donation (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(150) default NULL,
  type_id int(10) unsigned NOT NULL,
  amount int(10) unsigned NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (type_id) references donation_type(id),
  UNIQUE KEY name_type (name,type_id)
) TYPE=INNODB;

insert into donation(name, type_id,amount) values 
('primo trimestre',1,18),
('secondo trimestre',1,18),
('terzo trimestre',1,12),
('quarto trimestre',1,18),
('primo trimestre',2,27),
('secondo trimestre',2,27),
('terzo trimestre',2,18),
('quarto trimestre',2,27),
('primo trimestre',3,33),
('secondo trimestre',3,33),
('terzo trimestre',3,22),
('quarto trimestre',3,33);

/*
Tabella quote				
id	name  type	amount
1	I	1	
2	II	1	27	33
3	III	12	18	22
4	IV	18	27	33
*/

DROP TABLE IF EXISTS calendar;
CREATE TABLE calendar(
  id int(10) unsigned NOT NULL auto_increment,
  day DATE NOT NULL default '2000-01-01',
  status varchar(150) default NULL, /*  APERTURA/CHIUSURA	*/
  booking int(1) default 1,
  pickup int(1) default 1,
  PRIMARY KEY (id),
  INDEX (day)
) TYPE=INNODB;

insert into calendar (day, status, booking, pickup) values
(now(), 'apertura',1,1),
(date_add(now(),interval 7 day), 'apertura',1,1),
( date_add(now(), interval 14 day), 'apertura',1,1),
( date_add(now(), interval 21 day), 'apertura',1,1),
( date_add(now(), interval 28 day), 'apertura',1,1);

/* 
Status	
id	status
1	iscritto
2	cancellato
3	sospeso
4	nuovo
*/
DROP TABLE IF EXISTS user_status;
CREATE TABLE user_status (
  id int(10) unsigned NOT NULL auto_increment,
  status varchar(50) default NULL,
  description varchar(150) default NULL,
  PRIMARY KEY (id),
  UNIQUE KEY status (status)
) TYPE=INNODB;

insert into user_status(status) values 
('iscritto'),('sospeso'),('cancellato');

DROP TABLE IF EXISTS user;
CREATE TABLE user (
  id int(10) unsigned NOT NULL auto_increment,
  username varchar(200) NOT NULL DEFAULT '',
  password varchar(200) DEFAULT NULL,
  name varchar(50) default NULL,
  surname varchar(50) default NULL,
  email varchar(50) default NULL,
  email2 varchar(50) default NULL,
  tel varchar(50) default NULL,
  mobile varchar(50) default NULL,
  fax varchar(50) default NULL,
  address varchar(150) default NULL,
  status_id int(10) unsigned NOT NULL default 0,
  tesseraCasale int(10) unsigned NOT NULL default 0,
  entrance_fee int(10) unsigned NOT NULL default 0,
  donation_type_id int(10) unsigned default NULL,
  subscription_date DATE NOT NULL default '2000-01-01', 
  role_id int(10) unsigned not NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (donation_type_id) REFERENCES donation_type (id),
  FOREIGN KEY (role_id) REFERENCES role (id),
  FOREIGN KEY (status_id) REFERENCES user_status (id),
  UNIQUE KEY  email (email)
) TYPE=INNODB;


/*
DROP TABLE IF EXISTS user_role_lk;
CREATE TABLE user_role_lk (
  user_id int(10) unsigned NOT NULL,
  role_id int(10) unsigned NOT NULL,
  FOREIGN KEY (role_id) REFERENCES role (id),
  FOREIGN KEY (user_id) REFERENCES user (id)
) TYPE=INNODB;
*/


DROP TABLE IF EXISTS donation_paied;
CREATE TABLE donation_paied (
  id int(10) unsigned NOT NULL auto_increment,
  user_id int(10) unsigned NOT NULL,
  first   decimal(10,2) NOT NULL default 0,
  second  decimal(10,2) NOT NULL default 0,
  third   decimal(10,2) NOT NULL default 0,
  fourth  decimal(10,2) NOT NULL default 0,
  PRIMARY KEY (id),
  UNIQUE KEY (user_id),
  FOREIGN KEY (user_id) REFERENCES user (id)
) TYPE=INNODB;

/*
pagamento_quote			
id	gaabista	quota	pagato
1	1	1	 € 10,00 
2	3	2	 € 20,00 
3	4	1	 € 100,00 
4	1	2	 € 20,00 
	*/		

DROP TABLE IF EXISTS product_category;
CREATE TABLE product_category (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(50) default NULL,
  description varchar(100) default NULL,
  PRIMARY KEY (id),
  UNIQUE KEY name (name)
) TYPE=INNODB;
	
DROP TABLE IF EXISTS product;
CREATE TABLE product (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(150) default NULL,
  category_id int(10) unsigned NOT NULL,
  price decimal(10,2) NOT NULL default "0",
  disable int(5) unsigned NOT NULL default 0,
  unitprice int(5) unsigned NOT NULL default 1,
  description varchar(200) default NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (category_id) REFERENCES product_category (id),
  UNIQUE KEY name_category (name,category_id),
  INDEX  (name)
) TYPE=INNODB;

/*
Prodotti				
id	tipo	nome	 costo 	descrizione
1	sportina	sportina piccola	 € 8,50 	Una cassetta di frutta ( 30%) e verdura (70 %) di 5 kg
2	sportina	sportina grande	 € 17,00 	Una cassetta di frutta ( 30%) e verdura (70 %) di 10 kg
4	yogurt	 VASETTO PICCOLO 330 ml (6,06 € / Kg.) 	 € 2,00 	 VASETTO PICCOLO 330 ml (6,06 € / Kg.) 
5	yogurt	 VASETTO MEDIO 480 ml (6,25 € / Kg.) 	 € 4,00 	 VASETTO MEDIO 480 ml (6,25 € / Kg.) 
6	yogurt	 VASETTO GRANDE 660 ml (6,06 € / Kg.) 	 € 6,00 	 VASETTO GRANDE 660 ml (6,06 € / Kg.) 
7	pane	Bianco - 900	 € 4,05 	Bianco - 900
*/
	
DROP TABLE IF EXISTS booking;
CREATE TABLE booking (
  id int(10) unsigned NOT NULL auto_increment,
  booking_date_id int(10) unsigned NOT NULL,
  user_id int(10) unsigned NOT NULL,
  pickup_date_id int(10) unsigned NOT NULL,
  product_id int(10) unsigned NOT NULL,
  quantity decimal(10,2) unsigned NOT NULL,
  tot_price decimal(10,2) NOT NULL default "0",
  PRIMARY KEY (id),
  FOREIGN KEY (booking_date_id) REFERENCES calendar (id),
  FOREIGN KEY (user_id) REFERENCES user (id),
  FOREIGN KEY (pickup_date_id) REFERENCES calendar (id),
  FOREIGN KEY (product_id) REFERENCES product (id),
  UNIQUE KEY booking (booking_date_id,user_id,pickup_date_id,product_id)
  ) TYPE=INNODB;

/*
booking					
id	data ordine	utente	data ritiro	prodotto	quantità	tot (euro)
1	2	1	3	1	3	3*costo prodotto
2	3	1	3	3	1	1*costo prodotto
3	3	2	3	1	2	2*costo prodotto
*/	
	
DROP TABLE IF EXISTS user_payment;
CREATE TABLE user_payment (
  id int(10) unsigned NOT NULL auto_increment,
  user_id int(10) unsigned NOT NULL,
  date TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
  owed decimal(10,2) NOT NULL, 
  payed  decimal(10,2) NOT NULL,
  debit_credit  decimal(10,2) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES user (id)
) TYPE=INNODB;
/*
User_payments					
id	user	data	dovuto	pagato	credito_debito
1	2	1	20	19	-1
2	2	3	30	35	5
3	2	4	22	11	-11
4	3	2	17	20	3
*/


EOF
