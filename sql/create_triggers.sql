delimiter $$
create trigger insert_data_default_profile
after insert on usuarios
for each row
begin
	declare last_name varchar(50);
	declare uuid int;

    set uuid = (select user_id from usuarios order by 1 desc limit 1);
    set last_name = concat('User',uuid);

	insert into perfiles (user_id,username,descripcion,fechaRegistro) values (uuid,last_name,concat('This is the profile of ',last_name), now());
end $$
delimiter ;

-- drop trigger insert_data_default_profile
-- select user_id from usuarios order by 1 desc limit 1

delimiter $$
create trigger insert_reaction
after insert on posts
for each row
begin
	declare uid_post int;
	declare uuser_id int;

    set uid_post = (select id_post from posts order by 1 desc limit 1);
    set uuser_id = (select user_id from posts order by 1 desc limit 1);

	insert into reacciones (id_post,user_id,value)
	values (uid_post,uuser_id,false);
end $$
delimiter ;

-- drop trigger insert_data_default_profile
-- select user_id from usuarios order by 1 desc limit 1
