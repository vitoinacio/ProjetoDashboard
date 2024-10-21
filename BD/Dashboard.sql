create database dashboard;
use dashboard;
create table usuario (
id int primary key auto_increment,
nameOut varchar(80) not null,
sexo varchar(30), 
dataNasc varchar(10), 
email varchar (80),
senha varchar (8),
cpf varchar (14),
tel varchar (20),
cep varchar (10),
cidade varchar (25),
bairro varchar (25),
rua varchar (25),
numeroCasa varchar (25)
);
select * from usuario;


create table debito (
id_deb int primary key auto_increment,
ident_deb varchar(50),
data_venc varchar(10),
obs_deb varchar (50),
valor_deb decimal (15,2),
fk_id_usuario int, foreign key (fk_id_usuario) references usuario(id)
);

Alter table ent_financeira add unique (valor_ent);
alter table debito add unique (valor_deb);

create table gerador (
fk_valor_ent decimal (15,2),
fk_valor_deb decimal (15,2),
primary key (fk_valor_ent, fk_valor_deb),
constraint fk_ent foreign key (fk_valor_ent) references ent_financeira (valor_ent) on update cascade,
constraint fk_deb foreign key (fk_valor_deb) references debito (valor_deb) on update cascade
);



create table relatorio (
id_relatorio int primary key auto_increment,
total_ent decimal (15,2), 
total_deb decimal (15,2),
saldo_final decimal (15,2),
mes_ano varchar (25),
fk_id_usuario int, foreign key (fk_id_usuario) references usuario(id)
);



Delimiter //
create trigger atualiza_total_ent after insert on ent_financeira for each row
begin
	update relatorio
    set total_ent = (
			select sum(valor_ent) 
			from ent_financeira 
            where fk_id_usuario = new.fk_id_usuario
            )
    where fk_id_usuario = NEW.fk_id_usuario;
    end;


create trigger atualiza_total_deb after insert on debito for each row
begin
	update relatorio
    set total_deb = (
		select sum(valor_deb)
        from debito
        where fk_id_usuario = new.fk_id_usuario
        )
	where fk_id_usuario = new.fk_id_usuario;
    end;
    
delimiter//

show triggers;
   
    

    