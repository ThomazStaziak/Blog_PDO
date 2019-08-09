create table noticias (
	id int not null primary key auto_increment,
    titulo varchar(1000),
    descricao varchar(1000),
    categoria varchar(1000),
    data_criacao date,
    url_imagem varchar(1000),
    id_escritor int,
    foreign key(id_escritor) references escritores(id)
);