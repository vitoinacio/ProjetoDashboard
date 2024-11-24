CREATE DATABASE dashboard;
USE dashboard;
CREATE TABLE usuario (
id INT PRIMARY KEY AUTO_INCREMENT UNIQUE NOT NULL,
nome VARCHAR(80) NOT NULL,
sexo VARCHAR(30) NOT NULL, 
dataNasc VARCHAR(10) NOT NULL, 
email VARCHAR (80) NOT NULL UNIQUE,
senha VARCHAR (8) NOT NULL,
cpf VARCHAR (14) NOT NULL UNIQUE,
tel VARCHAR (20) NOT NULL,
cep VARCHAR (10) NOT NULL,
cidade VARCHAR (25) NOT NULL,
bairro VARCHAR (25) NOT NULL,
rua VARCHAR (25) NOT NULL,
numeroCasa VARCHAR (25) NOT NULL,
dtCriacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
adm VARCHAR (1) DEFAULT '0' 
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
fk_id_usuario int,
constraint fk_id_usuario_deb foreign key (fk_id_usuario) references usuario(id)
);




