create table usuarios (
	user_id int primary key auto_increment not null,
    correo varchar(25) not null,
    password varchar(25) not null
);

create table perfiles (
	user_id int,
    username varchar(15),
    descripcion varchar(50),
    fechaRegistro datetime,
    foreign key (user_id) references usuarios(user_id)
);

create table posts (
	id_post int not null primary key auto_increment,
    user_id int,
    descripcion varchar(50) not null,
    fechaRegistro datetime,
    foreign key (user_id) references usuarios(user_id)
);

create table reacciones (
	id_reaccion int not null primary key auto_increment,
    id_post int,
    user_id int,
    foreign key (id_post) references posts(id_post),
    foreign key (user_id) references usuarios(user_id)
);

create table comentarios (
	id_comentario int not null primary key auto_increment,
    id_post int,
    user_id int,
    descripcion varchar(50) not null,
    foreign key (id_post) references posts(id_post),
    foreign key (user_id) references usuarios(user_id)
);

select * from usuarios;

select count(*) as numReacciones
from posts p
inner join reacciones r
on (r.id_reaccion = p.id_post);
-- where p.id_post = 1;