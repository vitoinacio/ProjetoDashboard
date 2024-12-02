CREATE DATABASE dashboard;
USE dashboard;
CREATE TABLE usuario (
id INT PRIMARY KEY AUTO_INCREMENT UNIQUE NOT NULL,
nome VARCHAR(80) NOT NULL,
sexo VARCHAR(30) NOT NULL, 
dataNasc VARCHAR(10) NOT NULL, 
email VARCHAR (80) NOT NULL UNIQUE,
senha VARCHAR (255) NOT NULL,
cpf VARCHAR (14) NOT NULL UNIQUE,
tel VARCHAR (20) NOT NULL,
cep VARCHAR (10) NOT NULL,
cidade VARCHAR (25) NOT NULL,
bairro VARCHAR (25) NOT NULL,
rua VARCHAR (25) NOT NULL,
numeroCasa VARCHAR (25) NOT NULL,
foto BLOB NOT NULL,
dtCriacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
adm VARCHAR (1) DEFAULT '0' 
);

CREATE TABLE ent_financeira (
id_ent INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
fk_id_usuario INT NOT NULL,
CONSTRAINT fk_id_usuario_ent FOREIGN KEY (fk_id_usuario) REFERENCES usuario(id),
data_ent TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
valor_ent VARCHAR(255) NOT NULL
);

CREATE TABLE debito (
id_deb INT PRIMARY KEY auto_increment,
ident_deb VARCHAR(50),
data_venc VARCHAR(10),
obs_deb VARCHAR(50),
valor_deb DECIMAL (15,2),
notifi INT(1),
pago INT(1),
notificacao_enviada BOOLEAN DEFAULT FALSE,
fk_id_usuario INT,
CONSTRAINT fk_id_usuario_deb FOREIGN KEY (fk_id_usuario) REFERENCES usuario(id)
);

CREATE TABLE relatorio(
id_relatorio INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
fk_id_usuario INT NOT NULL,
total_entrada INT NOT NULL,
total_saida INT NOT NULL,
saldo_final INT NOT NULL,
CONSTRAINT fk_id_usuario_rel FOREIGN KEY (fk_id_usuario) REFERENCES usuario(id));