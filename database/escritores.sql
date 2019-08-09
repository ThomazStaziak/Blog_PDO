create table escritores (
	id int not null primary key auto_increment,
    nome varchar(1000),
    email varchar(1000) unique,
    senha varchar(1000)
);