create view perfil as
	select u.user_id, u.correo, u.password,
    p.username, p.descripcion, p.fechaRegistro
    from usuarios u
    inner join perfiles p
    on (p.user_id=u.user_id);

select * from perfil where user_id=14;

create view all_post as
	select per.username,
	p.descripcion,
	p.fechaRegistro from posts
	inner join perfiles per
	on (per.user_id=p.user_id);

alter view all_chats as
	select c.id_post, p.username, c.descripcion
	from comentarios c
	inner join perfil p
	on (p.user_id=c.user_id);