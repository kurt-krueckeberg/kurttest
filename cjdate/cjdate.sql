create database  cjdate;
use cjdate;
create table S (SNO CHAR(2) not null primary key,
SNAME varchar(50) not null,
STATUS integer not null, 
CITY varchar(25) not null) type=innodb;
 
create table P (PNO CHAR(2) not null primary key,
PNAME varchar(50) not null,
COLOR 	enum('red', 'green', 'blue') not null,
WEIGHT float not null, 
CITY varchar(25) not null) type=innodb;

create table SP (SNO CHAR(2) not null,
PNO CHAR(2) not null,
QTY integer not null, 
primary key(SNO, PNO),
foreign key(SNO) references S(SNO),
foreign key(PNO) references P(PNO)) type=innodb;

insert into S(SNO, SNAME, STATUS, CITY) values 
('S1','Smith', 20, 'London'),
('S2','Jones', 10, 'Paris'),
('S3','Blake', 30, 'Paris'),
('S4','Clark', 20, 'London'),
('S5','Admans', 30, 'Athens');

insert into P(PNO, PNAME, COLOR, WEIGHT, CITY) values 
('P1', 'Nut', 'Red', 12.0, 'London'),
('P2','Bolt', 'Green', 17.0, 'Paris'),
('P3','Screw', 'Blue', 17.0, 'Olso'),
('P4','Screw', 'Red', 14.0, 'London'),
('P5','Cam', 'Blue', 12.0, 'Paris'),
('P6', 'Cog', 'Red', 19.0, 'London');

insert into SP(SNO, PNO, QTY) values 
('S1', 'P1', 300),
('S1', 'P2', 200),
('S1', 'P3', 400),
('S1', 'P4', 200),
('S1', 'P5', 100),
('S1', 'P6', 100),
('S2', 'P1', 300),
('S2', 'P2', 400),
('S3', 'P2', 200),
('S4', 'P2', 200),
('S4', 'P4', 300),
('S4', 'P5', 400);
