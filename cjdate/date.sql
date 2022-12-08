create database sample;

create table s (
   sno CHAR[2],
   sname VARCHAR[8],
   status int,
   city VARCHAR[8],
primary key(sno)
);

insert into s values();

create table p (
   pno CHAR[2],
   pname CHAR,
   color VARCHAR[8],
   weight int,
   city VARCHAR[8],
primary key(pno)
);

insert into p values();

create table sp (
   sno CHAR,
   pno CHAR,
   qty CHAR,
primary key(sno)
);


insert into sp values();
