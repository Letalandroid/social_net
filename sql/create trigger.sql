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