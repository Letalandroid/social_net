create procedure sp_addUser (cor varchar(25), pssw varchar(25))
begin
	insert into usuarios (correo,password) values (cor,pssw)
end