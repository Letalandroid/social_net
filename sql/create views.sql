create view perfil as
	select u.user_id, u.correo, u.password,
    p.username, p.descripcion, p.fechaRegistro
    from usuarios u
    inner join perfiles p
    on (p.user_id=u.user_id);

select * from perfil where user_id=14;