create table board (
  idx int(11) primary key,
  name varchar(100) not null,
  pw varchar(100) not null,
  title varchar(100) not null,
  content text not null,
  date date not null,
  hit int(11) not null,
  file varchar(255) not null,
  realfile varchar(255) not null
) default charset=utf8;

create table gallery (
  id int(11) primary key auto_increment,
  description varchar(100) not null,
  fname varchar(255) not null,
  fdate date
) default charset=utf8;

create table consulting (
  id int(11) primary key auto_increment,
  dt timestamp default CURRENT_TIMESTAMP,
  dtok timestamp,
  statok boolean default false,
  name varchar(40) not null,
  phone varchar(30) not null,
  content text not null
) default charset=utf8;

create table calendar (
  id int(11) primary key auto_increment,
  dt timestamp not null default CURRENT_TIMESTAMP,
  part1 varchar(20),
  part2 varchar(20),
  part3 varchar(20)
) default charset=utf8;

create table admin (
  id varchar(20) primary key,
  pw varchar(200) not null
) default charset=utf8;

insert into admin values (
  'admin',
  '$2y$10$OkGPJ3lJXi5fpvh1Hr6fTu7aF5R2vHdKwzmzqMINgnxOkG/136rFe'
);
