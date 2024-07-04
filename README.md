Lista de tarefas em PHP que permite o usuário cadastrar e gerenciar tarefas. O sistema também possui sistema de cadastro de usuários.

Para testar o código, é necessário entrar no arquivo conecta_banco.php e mudar as credenciais de acesso para o banco do seu servidor.

As tabelas no MySql devem ser criadas no seguinte formato:

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(80) NOT NULL,
  `Senha` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

CREATE TABLE `tarefas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Userid` int(11) DEFAULT NULL,
  `Tarefa` varchar(255) NOT NULL,
  `Marcada` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Userid` (`Userid`),
  CONSTRAINT `tarefas_ibfk_1` FOREIGN KEY (`Userid`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
