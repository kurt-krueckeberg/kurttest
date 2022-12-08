create table S (
SNO CHAR[2],
SNAME VARCHAR[8],
STATUS int,
CITY VARCHAR[8],
primary key(SNO)
);

create table P (
PNO CHAR[2],
PNAME CHAR  ,
COLOR VARCHAR[8] ,
WEIGHT int,
CITY VARCHAR[8]
);

create table SP (
SNO CHAR  ,
PNO CHAR  ,
QTY CHAR  );


