CREATE DATABASE dashboard;
USE dashboard;
CREATE TABLE usuario (
id INT AUTO_INCREMENT UNIQUE NOT NULL,
nome VARCHAR(80) NOT NULL,
sexo VARCHAR(30) NOT NULL, 
dataNasc VARCHAR(10) NOT NULL, 
email VARCHAR (80) NOT NULL UNIQUE,
senha VARCHAR (8) NOT NULL,
cpf VARCHAR (14) NOT NULL PRIMARY KEY UNIQUE,
tel VARCHAR (20) NOT NULL,
cep VARCHAR (10) NOT NULL,
cidade VARCHAR (25) NOT NULL,
bairro VARCHAR (25) NOT NULL,
rua VARCHAR (25) NOT NULL,
numeroCasa VARCHAR (25) NOT NULL,
dtCriacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP 
);
CREATE TABLE ent_financeira (
id_ent INT AUTO_INCREMENT PRIMARY KEY NOT NULL UNIQUE,
fk_id_usuario INT NOT NULL,
CONSTRAINT fk_id_usuario_ent FOREIGN KEY (fk_id_usuario) REFERENCES usuario(id),
data_ent TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
valor_ent VARCHAR(255) NOT NULL
);
create table debito (
id_deb int primary key auto_increment,
ident_deb varchar(50),
data_venc varchar(10),
obs_deb varchar (50),
valor_deb decimal (15,2),
notifi varchar (2),
fk_id_usuario int, foreign key (fk_id_usuario) references usuario(id)
);

CREATE TABLE relatorio(
id_relatorio INT PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
fk_id_usuario INT NOT NULL,
total_entrada INT NOT NULL,
total_saida INT NOT NULL,
saldo_final INT NOT NULL,
CONSTRAINT fk_id_usuario_rel FOREIGN KEY (fk_id_usuario) REFERENCES usuario(id));

drop database dashboard;
drop table debito;
select * from usuario;
describe usuario;
describe ent_financeira;
describe debito;
alter table usuario rename column nameOut to nome;
SELECT DATE_FORMAT(dataNasc, '%d-%m-%Y') AS 'dataNasc' FROM usuario;
DELETE FROM usuario WHERE cpf = '192.894.957-66';	





