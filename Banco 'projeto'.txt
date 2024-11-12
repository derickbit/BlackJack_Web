CREATE DATABASE projeto;


CREATE TABLE pessoa (
	codpessoa INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(255) NOT NULL UNIQUE,
	email VARCHAR(255) NOT NULL,
	senha VARCHAR(255) DEFAULT md5('123') NOT NULL,
	reg_date DATE NOT NULL DEFAULT CURRENT_DATE
);

INSERT INTO `pessoa`( `nome`, `email`, `senha`) VALUES ('Derick','derick@gmail.com',md5('123'));
INSERT INTO `pessoa`( `nome`, `email`, `senha`) VALUES ('Barbara','barbara@gmail.com',md5('123'));
INSERT INTO `pessoa`( `nome`, `email`, `senha`) VALUES ('Daniel','daniel@gmail.com',md5('123'));
INSERT INTO `pessoa`( `nome`, `email`, `senha`) VALUES ('Jorge','jorge@gmail.com',md5('123'));
INSERT INTO `pessoa`( `nome`, `email`, `senha`) VALUES ('José','jose@gmail.com',md5('123'));
INSERT INTO `pessoa`( `nome`, `email`, `senha`) VALUES ('Maria','maria@gmail.com',md5('123'));
INSERT INTO `pessoa`( `nome`, `email`, `senha`) VALUES ('Miguel','miguel@gmail.com',md5('123'));
INSERT INTO `pessoa`( `nome`, `email`, `senha`) VALUES ('Nitiane','nitiane@gmail.com',md5('123'));

CREATE TABLE denuncia (
	coddenuncia INT AUTO_INCREMENT PRIMARY KEY,
	coddenunciante INT NOT NULL,
	coddenunciado INT NOT NULL,
	descricao VARCHAR(1000) NOT NULL,
	imagem VARCHAR(255) DEFAULT NULL,
	reg_date DATE NOT NULL DEFAULT CURRENT_DATE,
	FOREIGN KEY (coddenunciante) REFERENCES pessoa(codpessoa) ON DELETE CASCADE,
	FOREIGN KEY (coddenunciado) REFERENCES pessoa(codpessoa) ON DELETE CASCADE
);



CREATE TABLE partida (
	codpartida INT AUTO_INCREMENT PRIMARY KEY,
	codjogador1 INT NOT NULL,
	codjogador2 INT NOT NULL,
	codvencedor INT NOT NULL,
	pontuacao INT,
	reg_date DATE NOT NULL DEFAULT CURRENT_DATE,
	FOREIGN KEY (codjogador1) REFERENCES pessoa(codpessoa) ON DELETE CASCADE,
	FOREIGN KEY (codjogador2) REFERENCES pessoa(codpessoa) ON DELETE CASCADE,
	FOREIGN KEY (codvencedor) REFERENCES pessoa(codpessoa) ON DELETE CASCADE
);

