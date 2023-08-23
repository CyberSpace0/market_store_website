create database website;

create table login(id int NOT NULL AUTO_INCREMENT,username varchar(100),password varchar(200),session varchar(300),PRIMARY KEY(id),total int,image varchar(100),csrf_token(10000));

create table product(id int NOT NULL AUTO_INCREMENT,url
varchar(200),price int,PRIMARY KEY(id),title varchar(50));

insert into product(url,price,title) values('downloads/xxx.jpg',100,"playstation");
insert into product(url,price,title) values('downloads/xx.jpg',250,"raspery pi");
insert into product(url,price,title) values('downloads/x.jpg',25,"gift card");

