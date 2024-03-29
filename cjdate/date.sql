create datbase if not exists sample;

use sample;

create table if not exists s (
   sno CHAR[2],
   sname VARCHAR[8],
   status int,
   city VARCHAR[8],
primary key(sno)
);

insert into s values 
('S1', 'Smith', 20, 'London'),
('S2', 'Jones', 10, 'Paris'),
('S3', 'Blake', 30, 'Paris'),
('S4', 'Clark', 20, 'London');

create table if not exists p (
   pno CHAR[2],
   pname CHAR,
   color VARCHAR[8],
   weight int,
   city VARCHAR[8],
primary key(pno)
);

insert into p values

create table  if not exists sp (
   sno CHAR[2],
   pno CHAR[2],
   qty CHAR,
primary key(sno, pno)
);

insert into sp values TODO: Add supply numbers
(  'P1', 300),
( 'P2', 200),
( 'P2', 400),
( 'P3', 400),
( 'P4', 200),
( 'P5', 100),
( 'P6', 100);
